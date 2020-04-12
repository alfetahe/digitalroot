<?php

namespace digitalRootSrc;

class digitalRoot {
    private $inputData;
    private $orign_input;
    private $digitInMemory;
    private $digitsInMemory = [];
    private $digitInMemoryFirstChar;
    private $digitInMemorySecondChar;
    private $letterNumericValues;

    public function __construct($input, $alternative_values = null)
    {
        $this->inputData = $input;
        $this->orig_input = $input;
        $this->digitInMemory = 0;
        $this->digitsInMemory = [];
        $this->letterNumericValues = $alternative_values ?? require('config/letters.php');
    }

    /*  Main output methods */
    public function getDigRoot()
    {
      return (String)$this->digitInMemory;
    }

    public function getDigRootCompCalc() 
    {
        return $this->digitsInMemory;
    }

    public function getdigitalRootFullNumericResult()
    {
        return implode('', $this->digitsInMemory);
    }

    public function getOrigInput()
    {
        return $this->orig_input;
    }

    /* Worker methods */
    public function longCalculation()
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

    // For a non-zero number num, digital root is 9 if number is divisible by 9, else digital root is num % 9.
    public function shortCalculation()
    {
        $modulus = array_sum($this->inputData) % 9;

        $this->digitInMemory = $modulus == 0 ? 9 : $modulus;
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
        foreach ($this->inputData as $key => $char) {
            if (!is_numeric($char)) {
                $upperCaseChar = strtoupper($char);
                $this->inputData[$key] = $this->letterNumericValues[$upperCaseChar];
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