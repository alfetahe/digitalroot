<?php

namespace VortexMathSrc;

class Vortex {
    private $inputData;
    private $digitInMemory;
    private $digitsInMemory = [];
    private $digitInMemoryFirstChar;
    private $digitInMemorySecondChar;

    public function __construct($input)
    {
        $this->inputData = $input;
        $this->digitInMemory = 0;
        $this->digitsInMemory = [];
    }

    /*  Main output methods */
    public function getVortexFullDigitsResult()
    {
        return $this->digitsInMemory;
    }

    public function getVortexFullNumericResult()
    {
        return implode('', $this->digitsInMemory);
    }

    public function getVortexFinalResult()
    {
      return (String)$this->digitInMemory;
    }

    /* Worker methods */
    public function calculateDigits()
    {
        foreach ($this->inputData as $digit) {

            $this->digitInMemory = $this->digitInMemory + $digit;

            if (!$this->checkIfSingleDigit()) {
                $this->cutDoubleDigitInMemoryHalf();
                $this->addSingleDigits();
            }

            $this->addDigits();
        }
    }

    private function setFirstDigit() {
        if (is_array($this->inputData) && array_key_exists(0, $this->inputData)) {
            $this->digitsInMemory[0] = $this->inputData[0];
        }
    }

    private function checkIfSingleDigit()
    {
        return (strlen((string)$this->digitInMemory) == 1) ? true : false;
    }

    private function cutDoubleDigitInMemoryHalf()
    {
        $this->digitInMemoryFirstChar = substr($this->digitInMemory, 0, 1);
        $this->digitInMemorySecondChar = substr($this->digitInMemory, 1, 1);
    }

    private function addSingleDigits()
    {
        $this->digitInMemory = $this->digitInMemoryFirstChar + $this->digitInMemorySecondChar;
    }

    private function addDigits() {
        $this->digitsInMemory[] = (int)$this->digitInMemory;
    }

    public function convertLettersToNumbers()
    {
        $letterNumericValues = require('config/letters.php');

        foreach ($this->inputData as $key => $char) {
            if (!is_numeric($char)) {
                $upperCaseChar = strtoupper($char);
                $this->inputData[$key] = $letterNumericValues[$upperCaseChar];
            }
        }
    }

    public function cutInputForNumeric()
    {
        if (!empty($this->inputData)) {
            $this->inputData = preg_replace("/[^0-9]/", "", $this->inputData);
        }
    }

    public function cutInputForNumericLetters()
    {
        if (!empty($this->inputData)) {
            $this->inputData = preg_replace("/[^0-9a-zA-Z]/", "", $this->inputData);
        }
    }

    public function explodeIntegerInput()
    {
        if (ctype_digit($this->inputData)) {
            $this->inputData  = array_map('intval', str_split($this->inputData));
        }
    }

    public function explodeInput()
    {
        if (!empty($this->inputData)) {
            $this->inputData  = str_split($this->inputData);
        }
    }
    
}

?>