<?php
namespace AppBundle\Service;

use AppBundle\Entity\VoucherList;

class VoucherGenerator
{
    const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    const SAVE_DIR_NAME ='tmp';

    /**
     * @var VoucherList $voucherList
     */
    private $voucherList;

    /**
     * @var string
     */
    private $rootDir;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    /**
     * Generate code list and execute save
     */
    public function generate()
    {
        $this->_checkMaxAmount();
        $chars = self::CHARS;
        $numCodesToGenerate = $this->voucherList->getNumCodesToGenerate();
        $codeLen = $this->voucherList->getCodeLength();
        $codes =[];

        $n = 1;
        while($n<= $numCodesToGenerate) {
            $code = '';

            for ($i = 0; $i < $codeLen; $i++) {
                $code .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            $codes[$code] = $code;

            if ($n == $numCodesToGenerate) {
                $values = count(array_count_values($codes));
                $n -= $this->_countLack($values, $numCodesToGenerate);
            }
            $n++;
        }

        $this->_saveFile($codes);
    }


    public function setVoucherList(VoucherList $voucherList)
    {
        $this->voucherList = $voucherList;
    }


    /**
     * @param $values
     * @param $numCodesToGenerate
     * @return mixed
     */
    protected function _countLack($values, $numCodesToGenerate)
    {
        if ($values < $numCodesToGenerate) {
            return $numCodesToGenerate - $values;
        }
    }

    /**
     * Count max amount and setting max amount as numCodesToGenerate
     */
    protected function _checkMaxAmount()
    {
        $maxAmount = pow(strlen(self::CHARS),$this->voucherList->getCodeLength());

        if ($this->voucherList->getNumCodesToGenerate() > $maxAmount) {
            $this->voucherList->setNumCodesToGenerate((int) $maxAmount * 0.9);
        }
    }

    /**
     * @param $codes
     */
    protected function _saveFile($codes)
    {
        file_put_contents($this->_getSaveFilePath() . '.txt', implode(PHP_EOL, $codes) . "\n", FILE_USE_INCLUDE_PATH);
    }

    /**
     * @return string
     */
    protected function _getSaveFilePath()
    {
        return $this->rootDir . DIRECTORY_SEPARATOR . self::SAVE_DIR_NAME . DIRECTORY_SEPARATOR  . $this->voucherList->getFileName();
    }

}