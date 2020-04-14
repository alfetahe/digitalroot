<?php

namespace digitalRootSrc;

use \digitalRootSrc\digitalRootCalculator;

/**
 * Digitalroot input data worker class.
 */
class digitalRootInputWorker extends digitalRootCalculator
{
    /**
     * inputData
     *
     * @var mixed
     */
    protected $inputData;

    /**
     * letterNumericValues
     *
     * @var mixed
     */
    protected $letterNumericValues;

    /**
     * convertDigitsToInt
     *
     * @return void
     */
    protected function convertDigitsToInt(): void
    {
        $this->inputData  = array_map('intval', $this->inputData);
    }

    /**
     * convertLettersToNumbers
     *
     * @return void
     */
    protected function convertLettersToNumbers(): void
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
    protected function cutInputForNumeric(): void
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
    protected function cutInputForNumericLetters(): void
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
    protected function explodeIntegerInput(): void
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
    protected function explodeInput(): void
    {
        if (!empty($this->inputData)) {
            $this->inputData  = str_split($this->inputData);
        }
    }
}
