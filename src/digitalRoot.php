<?php

namespace digitalRootSrc;

use \digitalRootSrc\digitalRootInputWorker;

/**
 * digitalRoot
 */
class digitalRoot extends digitalRootInputWorker
{
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
        $this->cutInputForNumericLetters();
        $this->explodeInput();
        $this->convertLettersToNumbers();
        $this->convertDigitsToInt();
        $this->digitsInMemory = [];
        $this->digitInMemory = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->activeOrigDigit = isset($this->inputData[0]) ? $this->inputData[0] : 0;
        $this->fullCalculation = isset($this->inputData[0]) ? [$this->inputData[0]] : [];
        $this->origInput = $input;
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
  
}
