<?php

namespace digitalRootSrc;

/**
 * Digitalroot populator class.
 */
class digitalRootPopulator
{
    /**
     * Client input, original digits.  
     *
     * @var mixed
     */
    protected $orignInput;

    /**
     * Full calculation
     *
     * @var mixed
     */
    protected $fullCalculation;

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
}
