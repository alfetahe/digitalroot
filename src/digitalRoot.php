<?php

namespace digitalRootSrc;

use \digitalRootSrc\digitalRootInputWorker;

/**
 * digitalRoot
 */
class digitalRoot extends digitalRootInputWorker
{

    /**
     * Two possibilities from which the digital root can result.
     */
    const SINGLE_DIGIT_SUMMARY = "Summary from adding two single digits.";
    const DOUBLE_DIGIT_SEPARATION_SUMMARY = "Summary from splitting double digit value and adding both digits togather.";

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
        $this->letterNumericValues = $alternative_values ?? require('config/letters.php');
        // $this->cutInputForNumeric();
        $this->cutInputForNumericLetters();
        $this->explodeInput();
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

    /**
     * getSingleDigitSummaries
     *
     * @return array
     */
    public function getSingleDigitSummaries(): array
    {
        return $this->singleDigitSummaries;
    }

    /**
     * getDoubleDigitSummaries
     *
     * @return array
     */
    public function getDoubleDigitSummaries(): array
    {
        return $this->doubleDigitSummaries;
    }

    /**
     * getDigRootddsSeparated
     *
     * @return array
     */
    public function getDigRootddsSeparated(): array
    {
        return $this->ddsSeparated;
    }

    /**
     * getDigRootddssSummaries
     *
     * @return array
     */
    public function getDigRootddssSummaries(): array
    {
        return $this->ddssSummaries;
    }

    /**
     * getDigitalRootFrom
     *
     * @return string
     */
    public function getDigitalRootFrom(): string
    {
        return $this->digRootFrom;
    }
}
