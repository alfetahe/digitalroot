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
     * Single digit summaries. 
     *
     * @var mixed
     */
    protected $singleDigitSummaries;

    /**
     * Double digit summaries.  
     *
     * @var mixed
     */
    protected $doubleDigitSummaries;

    /**
     * Double digit summaries separated digits. 
     *
     * @var mixed
     */
    protected $ddsSeparated;

    /**
     * Summaries from separated double digits.  
     *
     * @var mixed
     */
    protected $ddssSummaries;

    /**
     * Full calculation
     *
     * @var mixed
     */
    protected $fullCalculation;

    /**
     * populateSingleDigitSummaries
     *
     * @return void
     */
    protected function populateSingleDigitSummaries(): void
    {
        $this->singleDigitSummaries[] = $this->digitInMemory;
    }

    /**
     * populateDoubleDigitSummaries
     *
     * @return void
     */
    protected function populateDoubleDigitSummaries(): void
    {
        $this->doubleDigitSummaries[] = $this->digitInMemory;
    }

    /**
     * populateDDSSepartedDigits
     *
     * @return void
     */
    protected function populateDDSSepartedDigits(): void
    {
        $this->ddsSeparated[] = $this->digitInMemoryFirstChar;
        $this->ddsSeparated[] = $this->digitInMemorySecondChar;
    }

    /**
     * populateDdssSummaries
     *
     * @return void
     */
    protected function populateDdssSummaries(): void
    {
        $this->ddssSummaries[] =  $this->digitInMemory;
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
}
