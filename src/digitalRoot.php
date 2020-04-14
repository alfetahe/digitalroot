<?php

namespace digitalRootSrc;

use phpDocumentor\Reflection\Types\Boolean;

/**
 * digitalRoot
 */
class digitalRoot
{

    /**
     * Two possibilities from which the digital root can result.
     */ 
    const SINGLE_DIGIT_SUMMARY = "Summary from adding two single digits.";
    const DOUBLE_DIGIT_SEPARATION_SUMMARY = "Summary from splitting double digit value and adding both digits togather.";
    
    /**
     * inputData
     *
     * @var mixed
     */
    private $inputData;
        
    /**
     * digitInMemory
     *
     * @var int
     */
    private $digitInMemory;  

    /**
     * digitsInMemory
     *
     * @var array
     */
    private $digitsInMemory = [];
        
    /**
     * digitInMemoryFirstChar
     *
     * @var int
     */
    private $digitInMemoryFirstChar;
    
    /**
     * digitInMemorySecondChar
     *
     * @var int
     */
    private $digitInMemorySecondChar;
    
    /**
     * letterNumericValues
     *
     * @var mixed
     */
    private $letterNumericValues;
    
    /**
     * activeOrigDigit
     *
     * @var mixed
     */
    private $activeOrigDigit;
    
    /**
     * Digital root last calculation cycle type.
     *
     * @var mixed
     */
    private $digRootFrom;
  
    /**
     * Client input, original digits.  
     *
     * @var mixed
     */
    private $orignInput;
   
    /**
     * Single digit summaries. 
     *
     * @var mixed
     */
    private $singleDigitSummaries;
  
    /**
     * Double digit summaries.  
     *
     * @var mixed
     */
    private $doubleDigitSummaries;
   
    /**
     * Double digit summaries separated digits. 
     *
     * @var mixed
     */
    private $ddsSeparated;
  
    /**
     * Summaries from separated double digits.  
     *
     * @var mixed
     */
    private $ddssSummaries;

    /**
     * Full calculation
     *
     * @var mixed
     */
    private $fullCalculation;

    
    /**
     * __construct
     *
     * @param  mixed $input
     * @param  mixed $alternative_values
     * @return void
     */
    public function __construct(string $input, array $alternative_values = null)
    {
        $this->inputData = $input;
        // $this->cutInputForNumeric();
        $this->cutInputForNumericLetters();
        $this->explodeInput();
        $this->letterNumericValues = $alternative_values ?? require('config/letters.php');
        $this->convertLettersToNumbers();
        $this->convertDigitsToInt();
        $this->digitsInMemory = [];
        $this->digitInMemory = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->activeOrigDigit = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->fullCalculation = isset($this->inputData[0]) ? [$this->inputData[0]] : [];
        $this->origInput = $input;
        $this->singleDigitSummaries = [];
        $this->doubleDigitSummaries = [];
        $this->ddssSummaries = [];
    }
 

    /**
     * MAIN OUTPUT METHODS
     */

    /**
     * getDigRoot
     *
     * @return int
     */
    public function getDigRoot() : int
    {
        return $this->digitInMemory;
    }
    
    /**
     * getOrigInput
     *
     * @return string
     */
    public function getOrigInput() : string
    {
        return $this->origInput;
    }
    
    /**
     * getDigRootFullCalculation
     *
     * @return array
     */
    public function getDigRootFullCalculation() : array
    {
        return [
            'string' => implode(' ', $this->fullCalculation),
            'array' => $this->fullCalculation
        ];
    }
    
    /**
     * getSingleDigitSummaries
     *
     * @return array
     */
    public function getSingleDigitSummaries() : array
    {
        return [
            'string' => implode(' ', $this->singleDigitSummaries),
            'array' => $this->singleDigitSummaries
        ];
    }
    
    /**
     * getDoubleDigitSummaries
     *
     * @return array
     */
    public function getDoubleDigitSummaries() : array
    {
        return [
            'string' => implode(' ', $this->doubleDigitSummaries),
            'array' => $this->doubleDigitSummaries
        ];
    }
    
    /**
     * getDigRootddsSeparated
     *
     * @return array
     */
    public function getDigRootddsSeparated() : array
    {
        return [
            'string' => implode(' ', $this->ddsSeparated),
            'array' => $this->ddsSeparated
        ];
    }
    
    /**
     * getDigRootddssSummaries
     *
     * @return array
     */
    public function getDigRootddssSummaries() : array
    {
        return [
            'string' => implode(' ', $this->ddssSummaries),
            'array' => $this->ddssSummaries
        ];
    }
    
    /**
     * getDigitalRootFrom
     *
     * @return string
     */
    public function getDigitalRootFrom() : string
    {
        return $this->digRootFrom;
    }


    /**
     * WORKER METHODS
     */
   
    /**
     * For a non-zero number num, digital root is 9 if number is divisible by 9, else digital root is num % 9.
     *
     * @return void
     */
    public function shortCalculation() : void
    {
        $modulus = array_sum($this->inputData) % 9;

        $this->digitInMemory = $modulus == 0 ? 9 : $modulus;
    }
    
    /**
     * Creates long calculation for the digitalroot. Provides different kind of data.
     *
     * @return void
     */
    public function longCalculation() : void
    {
        // We dont loop thru first element since it is already added in the construction method.
        foreach (array_slice($this->inputData, 1) as $digit) {

            $this->activeOrigDigit = $digit;

            $this->digitInMemory = $this->digitInMemory + $digit;

            $this->populateFullCalculation();

            if ($this->checkIfDoubleDigit()) {
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

        $this->setDigitalRootFrom();
    }
    
    /**
     * checkIfDoubleDigit
     *
     * @param  mixed $digits
     * @return bool
     */
    private function checkIfDoubleDigit(int $digits = null) : bool
    {
        $digits = $digits ?? $this->digitInMemory;

        return (strlen((string) $digits) == 2) ? true : false;
    }
    
    /**
     * setDigitalRootFrom
     *
     * @return void
     */
    private function setDigitalRootFrom() : void
    {
        // The last fourth element must be two digit element if the digital root
        // comes from the double digit separation summary.
        $x = count((array) $this->fullCalculation) - 4;
        if (isset($this->fullCalculation[$x]) && $this->checkIfDoubleDigit($this->fullCalculation[$x])) {
            $this->digRootFrom = digitalRoot::DOUBLE_DIGIT_SEPARATION_SUMMARY;
        } else {
            $this->digRootFrom = digitalRoot::SINGLE_DIGIT_SUMMARY;
        }
    }
    
    /**
     * addSingleDigits
     *
     * @return void
     */
    private function addSingleDigits() : void
    {
        $this->digitInMemory = $this->digitInMemoryFirstChar + $this->digitInMemorySecondChar;
        // Adds automatically summaries from separated double digits to the array.
        $this->populateDdssSummaries();
        $this->unsetMethod();
        $this->populateFullCalculation();
    }
    
    /**
     * Unsetting method for the full calculation method .
     *
     * @return void
     */
    private function unsetMethod() : void
    {
        unset($this->digitInMemoryFirstChar);
        unset($this->digitInMemorySecondChar);
        unset($this->activeOrigDigit);
    }


    /**
     * INPUT DATA WORKER METHODS
     */
        
    /**
     * convertDigitsToInt
     *
     * @return void
     */
    public function convertDigitsToInt() : void
    {
        $this->inputData  = array_map('intval', $this->inputData);
    }
    
    /**
     * convertLettersToNumbers
     *
     * @return void
     */
    public function convertLettersToNumbers() : void
    {
        foreach ($this->inputData as $key => $char) {
            if (!is_numeric($char)) {
                $upperCaseChar = strtoupper($char);
                $this->inputData[$key] = $this->letterNumericValues[$upperCaseChar];
            }
        }
    }
    
    /**
     * cutInputForNumeric
     *
     * @return void
     */
    public function cutInputForNumeric() : void
    {
        if (!empty($this->inputData)) {
            $this->inputData = preg_replace("/[^0-9]/", "", $this->inputData);
        }
    }
    
    /**
     * cutInputForNumericLetters
     *
     * @return void
     */
    public function cutInputForNumericLetters() : void
    {
        if (!empty($this->inputData)) {
            $this->inputData = preg_replace("/[^0-9a-zA-Z]/", "", $this->inputData);
        }
    }
    
    /**
     * explodeIntegerInput
     *
     * @return void
     */
    public function explodeIntegerInput() : void
    {
        if (ctype_digit($this->inputData)) {
            $this->inputData  = array_map('intval', str_split($this->inputData));
        }
    }
    
    /**
     * explodeInput
     *
     * @return void
     */
    public function explodeInput() : void
    {
        if (!empty($this->inputData)) {
            $this->inputData  = str_split($this->inputData);
        }
    }
    
    /**
     * cutDoubleDigitInMemoryHalf
     *
     * @return void
     */
    private function cutDoubleDigitInMemoryHalf() : void
    {
        $this->digitInMemoryFirstChar = (int) substr($this->digitInMemory, 0, 1);
        $this->digitInMemorySecondChar = (int) substr($this->digitInMemory, 1, 1);
    }

    /**
     * FUNCTIONS FOR POPULATING THE OUTPUT ARRAYS.
     */
       
    /**
     * populateSingleDigitSummaries
     *
     * @return void
     */
    private function populateSingleDigitSummaries() : void
    {
        $this->singleDigitSummaries[] = $this->digitInMemory;
    }
    
    /**
     * populateDoubleDigitSummaries
     *
     * @return void
     */
    private function populateDoubleDigitSummaries() : void
    {
        $this->doubleDigitSummaries[] = $this->digitInMemory;
    }
    
    /**
     * populateDDSSepartedDigits
     *
     * @return void
     */
    private function populateDDSSepartedDigits() : void
    {
        $this->ddsSeparated[] = $this->digitInMemoryFirstChar;
        $this->ddsSeparated[] = $this->digitInMemorySecondChar;
    }
    
    /**
     * populateDdssSummaries
     *
     * @return void
     */
    private function populateDdssSummaries() : void
    {
        $this->ddssSummaries[] =  $this->digitInMemory;
    }
    
    /**
     * populateFullCalculation
     *
     * @return void
     */
    private function populateFullCalculation() : void
    {
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
    
    /**
     * populateDigits
     *
     * @return void
     */
    private function populateDigits() : void
    {
        $this->digitsInMemory[] = (int) $this->digitInMemory;
    }
}
