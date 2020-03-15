<?php

namespace digitalRootSrc;

use digitalRootSrc\digitalRoot;

class digitalRootBuilder {
    public $digitalRootModel;

    // Builds single digitalRoot instance.
    private function buildSingleInstance($input) {
        $this->digitalRootModel = new digitalRoot($input);
    
        // $digitalRootModel->cutInputForNumeric();

        $this->digitalRootModel->cutInputForNumericLetters();

        $this->digitalRootModel->explodeInput();

        $this->digitalRootModel->convertLettersToNumbers();

        $this->digitalRootModel->calculateDigits();
    }

    public function getDigitalRoot($input)
    {
        $this->buildSingleInstance($input);

        return $this->digitalRootModel->getDigitalRoot();
    }

    public function getdigitalRootFullResult($input) 
    {
        $this->buildSingleInstance($input);

        return [
            'digits' => $this->digitalRootModel->getDigitalRootCompleteCalculation(),
            'numeric' => $this->digitalRootModel->getdigitalRootFullNumericResult()
        ];
    }

    public function getdigitalRootBulkResult($values) {
        $returnData = [];

        foreach($values as $value) {
            $this->buildSingleInstance($value);
            $returnData[$value] = $this->digitalRootModel->getDigitalRoot();
        }

        return $returnData;
    }
}

?>
