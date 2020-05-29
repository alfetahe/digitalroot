<?php

namespace digitalRootSrc;

use \digitalRootSrc\inputWorker;

/**
 * digitalRoot
 */
class digitalRoot
{
    /**
     * inputWorker
     *
     * @var mixed
     */
    protected $inputWorker;

    /**
     * Client input, original digits.  
     *
     * @var string
     */
    protected $orignInput;

    /**
     * digitInMemory
     *
     * @var int
     */
    protected $digitInMemory;

    /**
     * digitsInMemory
     *
     * @var array
     */
    protected $digitsInMemory = [];

    /**
     * digitInMemoryFirstChar
     *
     * @var int
     */
    protected $digitInMemoryFirstChar;

    /**
     * digitInMemorySecondChar
     *
     * @var int
     */
    protected $digitInMemorySecondChar;

    /**
     * activeOrigDigit
     *
     * @var mixed
     */
    protected $activeOrigDigit;

    /**
     * __construct
     *
     * @param  mixed $input
     * @param  mixed $alternative_values
     * @return void
     */
    public function __construct(string $input, array $alternative_values = null)
    {
        $this->inputWorker = new inputWorker($input);
        $this->digitInMemory = isset($this->inputWorker->getProcessedInputData()[0]) ? $this->inputWorker->getProcessedInputData()[0] : 0;
        $this->activeOrigDigit = isset($this->inputWorker->getProcessedInputData()[0]) ? $this->inputWorker->getProcessedInputData()[0] : 0;
        $this->fullCalculation = isset($this->inputWorker->getProcessedInputData()[0]) ? [$this->inputWorker->getProcessedInputData()[0]] : [];
        $this->origInput = $input;
    }


    /** Get functions start */

    /**
     * getDigRoot
     *
     * @return int
     */
    public function getDigRoot(): int
    {
        return $this->digitInMemory;
    }

    /**
     * getOrigInput
     *
     * @return string
     */
    public function getOrigInput(): string
    {
        return $this->origInput;
    }

    /**
     * getDigRootFullCalculation
     *
     * @return array
     */
    public function getDigRootFullCalculation(): array
    {
        return $this->fullCalculation;
    }

    /** Get functions end */
  

    /** Calculation functions start */

     /**
     * For a non-zero number num, digital root is 9 if number is divisible by 9, else digital root is num % 9.
     *
     * @return void
     */
    public function shortCalculation(): void
    {
        $modulus = array_sum($this->inputWorker->getProcessedInputData()) % 9;

        $this->digitInMemory = $modulus == 0 ? 9 : $modulus;
    }

    /**
     * Creates long calculation for the digitalroot. Provides different kind of data.
     *
     * @return void
     */
    public function longCalculation(): void
    {
        // We dont loop thru first element since it is already added in the construction method.
        foreach (array_slice($this->inputWorker->getProcessedInputData(), 1) as $digit) {
            $this->activeOrigDigit = $digit;

            $this->digitInMemory = $this->digitInMemory + $digit;

            $this->populateFullCalculation();

            if ($this->checkIfDoubleDigit()) {
                $this->doubleDigitWorker();
            }

            $this->populateDigits();
        }
    }

    /** Calculation functions end */


    /** Worker functions start */

/**
     * checkIfDoubleDigit
     *
     * @param  mixed $digits
     * @return bool
     */
    private function checkIfDoubleDigit(int $digits = null): bool
    {
        $digits = $digits ?? $this->digitInMemory;

        return (strlen((string) $digits) == 2) ? true : false;
    }

    /**
     * Calls the necessary functions for double digits.
     *
     * @return void
     */
    private function doubleDigitWorker()
    {
        $this->cutDoubleDigitInMemoryHalf();
        $this->populateFullCalculation();
        $this->addSingleDigits();
    }

    /**
     * addSingleDigits
     *
     * @return void
     */
    private function addSingleDigits(): void
    {
        $this->digitInMemory = $this->digitInMemoryFirstChar + $this->digitInMemorySecondChar;
        $this->unsetMethod();
        $this->populateFullCalculation();
    }

    /**
     * Unsetting method for the full calculation method .
     *
     * @return void
     */
    private function unsetMethod(): void
    {
        unset($this->digitInMemoryFirstChar);
        unset($this->digitInMemorySecondChar);
        unset($this->activeOrigDigit);
    }

    /**
     * cutDoubleDigitInMemoryHalf
     *
     * @return void
     */
    protected function cutDoubleDigitInMemoryHalf(): void
    {
        $this->digitInMemoryFirstChar = (int) substr($this->digitInMemory, 0, 1);
        $this->digitInMemorySecondChar = (int) substr($this->digitInMemory, 1, 1);
    }

    /**
     * populateFullCalculation
     *
     * @return void
     */
    protected function populateFullCalculation(): void
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
    protected function populateDigits(): void
    {
        $this->digitsInMemory[] = (int) $this->digitInMemory;
    }

    /** Worker functions end */

}
