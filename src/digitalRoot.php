<?php

namespace digitalRootSrc;

use \digitalRootSrc\inputWorker;

/**
 * digitalRoot
 */
class digitalRoot extends digitalRootCalculator
{
        
    /**
     * inputWorker
     *
     * @var mixed
     */
    protected $inputWorker;

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
        $this->digitsInMemory = [];
        $this->digitInMemory = isset($this->inputWorker->getProcessedInputData()[0]) ? $this->inputWorker->getProcessedInputData()[0] : 0;
        $this->activeOrigDigit = isset($this->inputWorker->getProcessedInputData()[0]) ? $this->inputWorker->getProcessedInputData()[0] : 0;
        $this->fullCalculation = isset($this->inputWorker->getProcessedInputData()[0]) ? [$this->inputWorker->getProcessedInputData()[0]] : [];
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
