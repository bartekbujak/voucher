<?php
namespace AppBundle\Service;

class VoucherGenerator
{
    const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    const DEFAULT_FILE_NAME = 'codes.txt';

    private $numCodesToGenerate;

    private $codeLength;

    private $fileName;

    public function generate() {
        $this->_checkMaxAmount();
        $chars = self::CHARS;
        $numCodesToGenerate = $this->numCodesToGenerate;
        $codeLen = $this->codeLength;
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

    /**
     * @param $num
     */
    public function setNumCodesToGenerate($num)
    {
        $this->numCodesToGenerate = $num;
    }

    /**
     * @param $length
     */
    public function setCodeLength($length)
    {
        $this->codeLength = $length;
    }

    /**
     * @param $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param $values
     * @return mixed
     */
    protected function _countLack($values)
    {
        if ($values < $this->numCodesToGenerate) {
            return $this->numCodesToGenerate - $values;
        }
    }

    /**
     * Count max amount and setting max amount as numCodesToGenerate
     */
    protected function _checkMaxAmount()
    {
        $maxAmount = pow(strlen(self::CHARS),$this->codeLength);

        if ($this->numCodesToGenerate > $maxAmount) {
            $this->setNumCodesToGenerate((int) $maxAmount * 0.9);
        }
    }

    /**
     * @param $filename
     * @param $codes
     */
    protected function _saveFile($codes)
    {

        file_put_contents($this->fileName, implode(PHP_EOL, $codes) . "\n", FILE_USE_INCLUDE_PATH	);
    }

}