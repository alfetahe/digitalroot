<?php

namespace digitalRootSrc;

class digitalRoot {

    // TODO
    // Two possibilities from which the digital root can result.
    const SINGLE_DIGIT_SUMMARY = "Summary from single digits.";
    const DOUBLE_DIGITS_SEPARATION_SUMMARY = "Summary from separated double digits.";

    private $inputData;
    private $digitInMemory;
    private $digitsInMemory = [];
    private $digitInMemoryFirstChar;
    private $digitInMemorySecondChar;
    private $letterNumericValues;
    private $activeOrigDigit;

    // From what calculation came the digital root.
    private $DigitalRootFrom;

    // Client input, original digits.
    private $orignInput;

    // Single digit summaries.
    private $singleDigitSummaries;

    // Double digit summaries.
    private $doubleDigitSummaries;

    // Double digit summaries separated digits.
    private $ddsSeparated;

    // Summaries from separated double digits.
    private $ddssSummaries;

    // Full calculation
    private $fullCalculation;


    public function __construct($input, $alternative_values = null)
    {
        $this->inputData = $input;

        // $digitalRootModel->cutInputForNumeric();
        $this->cutInputForNumericLetters();
        $this->explodeInput();

        $this->letterNumericValues = $alternative_values ?? require('config/letters.php');
        $this->convertLettersToNumbers();

        $this->convertDigitsToInt();

        $this->digitsInMemory = [];
        // Set the first digit from client input to the first digit in memory and to the full calculation array.
        $this->digitInMemory = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->activeOrigDigit = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->fullCalculation = isset($this->inputData[0]) ? [$this->inputData[0]] : [];
        $this->origInput = $input;
        $this->singleDigitSummaries = [];
        $this->doubleDigitSummaries = [];
        $this->ddssSummaries = [];
    }

    /*  Main output methods */
    public function getDigRoot()
    {
      return $this->digitInMemory;
    }
    
    public function getOrigInput()
    {
        return $this->origInput;
    }

    public function getDigRootFullCalculation() 
    {
        return [
          'string' => implode('', $this->fullCalculation),
          'array' => $this->fullCalculation
        ];
    }

    public function getSingleDigitSummaries() 
    {
        return [
            'string' => implode('', $this->singleDigitSummaries),
            'array' => $this->singleDigitSummaries
        ];
    }

    public function getDoubleDigitSummaries() 
    {
        return [
            'string' => implode('', $this->doubleDigitSummaries),
            'array' => $this->doubleDigitSummaries
        ];
    }

    public function getDigRootddsSeparated() 
    {
        return [
            'string' => implode('', $this->ddsSeparated),
            'array' => $this->ddsSeparated
        ];
    }

    public function getDigRootddssSummaries() 
    {
        return [
            'string' => implode('', $this->ddssSummaries),
            'array' => $this->ddssSummaries
        ];
    }

    /* Worker methods */

    // For a non-zero number num, digital root is 9 if number is divisible by 9, else digital root is num % 9.
    public function shortCalculation()
    {
        $modulus = array_sum($this->inputData) % 9;

        $this->digitInMemory = $modulus == 0 ? 9 : $modulus;
    }

    public function longCalculation()
    {
        // We dont loop thru first element since it is already added in the construction method.
        foreach (array_slice($this->inputData, 1) as $digit) {

            $this->activeOrigDigit = $digit;

            $this->digitInMemory = $this->digitInMemory + $digit;

            $this->populateFullCalculation();

            if (!$this->checkIfSingleDigit()) {
                $this->populateDoubleDigitSummaries();
                $this->cutDoubleDigitInMemoryHalf();
                $this->populateDDSSepartedDigits();
                $this->populateFullCalculation();
                $this->addSingleDigits();
            } else {
                $this->populateSingleDigitSummaries();
            }

            $this->populateDigits();
        }
    }


    private function setFirstDigit() {
        if (is_array($this->inputData) && array_key_exists(0, $this->inputData)) {
            $this->digitsInMemory[0] = $this->inputData[0];
        }
    }

    private function checkIfSingleDigit()
    {
        return (strlen((String)$this->digitInMemory) == 1) ? true : false;
    }

    private function addSingleDigits()
    {
        $this->digitInMemory = $this->digitInMemoryFirstChar + $this->digitInMemorySecondChar;
        // Adds automatically summaries from separated double digits to the array.
        $this->populateDdssSummaries();
        $this->unsetMethod();
        $this->populateFullCalculation();
    }

    // Unsets first and second digit in memory for populating the full calculation method.
    private function unsetMethod() {
        unset($this->digitInMemoryFirstChar);
        unset($this->digitInMemorySecondChar);
        unset($this->activeOrigDigit);
    }


    // Input data worker methods.
    public function convertDigitsToInt() {
        $this->inputData  = array_map('intval', $this->inputData);
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

    private function cutDoubleDigitInMemoryHalf()
    {
        $this->digitInMemoryFirstChar = (int)substr($this->digitInMemory, 0, 1);
        $this->digitInMemorySecondChar = (int)substr($this->digitInMemory, 1, 1);
    }



    // Functions for populating output arrays.
    private function populateSingleDigitSummaries() {
        $this->singleDigitSummaries[] = $this->digitInMemory;
    }

    private function populateDoubleDigitSummaries() {
        $this->doubleDigitSummaries[] = $this->digitInMemory;
    }

    private function populateDDSSepartedDigits() {
        $this->ddsSeparated[] = $this->digitInMemoryFirstChar;
        $this->ddsSeparated[] = $this->digitInMemorySecondChar;
    }

    private function populateDdssSummaries() {
        $this->ddssSummaries[] =  $this->digitInMemory;
    }

    private function populateFullCalculation() {
        if (isset($this->digitInMemoryFirstChar) && isset($this->digitInMemorySecondChar)) {
            $this->fullCalculation[] = $this->digitInMemoryFirstChar;
            $this->fullCalculation[] = $this->digitInMemorySecondChar;
        } elseif (isset($this->activeOrigDigit)) {
            $this->fullCalculation[] = $this->activeOrigDigit;
            $this->fullCalculation[] = $this->digitInMemory;
        } else {
            $this->fullCalculation[] = $this->digitInMemory;
        }
    }

    private function populateDigits() {
        $this->digitsInMemory[] = (int)$this->digitInMemory;
    }
    
}

?>