<?php
namespace AppBundle\Service;

class VoucherGenerator
{
    const CHARS = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    private $numCodesToGenerate;

    private $codeLength;

    public function generate() {
        $chars = self::CHARS;
        $numCodesToGenerate = $this->numCodesToGenerate;
        $codeLen = $this->codeLength;
        $codes =[];
        $possibles = pow(strlen($chars),$codeLen);

        if ($numCodesToGenerate > $possibles) {
            $numCodesToGenerate = (int) $possibles * 0.9;
        }

        $n = 1;

        while($n<= $numCodesToGenerate) {
            $code = '';

            for ($i = 0; $i < $codeLen; $i++) {
                $code .= $chars[mt_rand(0, strlen($chars)-1)];
            }
            $codes[$code] = $code;

            if ($n == $numCodesToGenerate) {
                $vals = count(array_count_values($codes));

                if ($vals < $numCodesToGenerate) {
                    $n -=$numCodesToGenerate - $vals;
                }
            }
            $n++;
        }

        $this->_saveFile('codes.txt', $codes);
    }

    protected function _saveFile($filename, $codes)
    {
        file_put_contents($filename, implode("\n", $codes) . "\n", FILE_APPEND);
    }

    public function setNumCodesToGenerate($num)
    {
        $this->numCodesToGenerate = $num;
    }

    public function setCodeLength($length)
    {
        $this->codeLength = $length;
    }
}