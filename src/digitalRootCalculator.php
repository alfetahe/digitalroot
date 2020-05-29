<?php

namespace digitalRootSrc;

use \digitalRootSrc\digitalRootPopulator;

/**
 * Digitalroot calculator class.
 */
class digitalRootCalculator extends digitalRootPopulator
{
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
     * For a non-zero number num, digital root is 9 if number is divisible by 9, else digital root is num % 9.
     *
     * @return void
     */
    public function shortCalculation(): void
    {
        $modulus = array_sum($this->inputData) % 9;

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
        foreach (array_slice($this->inputData, 1) as $digit) {
            $this->activeOrigDigit = $digit;

            $this->digitInMemory = $this->digitInMemory + $digit;

            $this->populateFullCalculation();

            if ($this->checkIfDoubleDigit()) {
                $this->doubleDigitWorker();
            }

            $this->populateDigits();
        }

    }

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
}
