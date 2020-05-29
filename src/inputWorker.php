<?php

namespace digitalRootSrc;

/**
 * Digitalroot input data worker class.
 */
class inputWorker
{
    /**
     * inputData
     *
     * @var mixed
     */
    private $inputData;

    /**
     * origInputData
     *
     * @var string
     */
    private $origInputData;

    /**
     * letterNumericValues
     *
     * @var array
     */
    public $letterNumericValues;

    /**
     * __construct
     *
     * @param  mixed $inputData
     * @return void
     */
    public function __construct(string $inputData, $alternative_values = null)
    {
        $this->inputData = $inputData;
        $this->origInputData = $inputData;
        $this->letterNumericValues = $alternative_values ?? require('config/letters.php');
        $this->cutInputForNumericLetters();
        $this->explodeInput();
        $this->convertLettersToNumbers();
        $this->convertDigitsToInt();
    }

    /**
     * getOrigInputData
     *
     * @return void
     */
    public function getOrigInputData()
    {
        return $this->origInputData;
    }

    /**
     * getProcessedInputData
     *
     * @return void
     */
    public function getProcessedInputData()
    {
        return $this->inputData;
    }

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
            $this->inputData = str_split($this->inputData);
        } else {
            $this->inputData = [];
        }
    }
}
