<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class VoucherList
{
    /**
     * @var integer
     * @Assert\LessThan(20)
     * @Assert\GreaterThan(2)
     * @ORM\Column(name="code_length", type="integer", length=11)
     */
    private $codeLength;

    /**
     * @var integer
     * @Assert\LessThan(1000001)
     * @Assert\GreaterThan(10)
     * @ORM\Column(name="num_codes_to_generate", type="integer", length=11)
     */
    private $numCodesToGenerate;

    /**
     * @var string
     * @ORM\Column(name="file_name", type="string", length=128)
     */
    private $fileName;

    /**
     * @return int
     */
    public function getCodeLength()
    {
        return $this->codeLength;
    }

    /**
     * @param int $codeLength
     */
    public function setCodeLength($codeLength)
    {
        $this->codeLength = $codeLength;
    }

    /**
     * @return int
     */
    public function getNumCodesToGenerate()
    {
        return $this->numCodesToGenerate;
    }

    /**
     * @param int $numCodesToGenerate
     */
    public function setNumCodesToGenerate($numCodesToGenerate)
    {
        $this->numCodesToGenerate = $numCodesToGenerate;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

}