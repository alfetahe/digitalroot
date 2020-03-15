<?php

namespace digitalRootSrc;

use digitalRootSrc\digitalRoot;

class digitalRootBuilder {
    public $digitalRootModel;

    // Builds single digitalRoot instance.
    private function buildSingleInstance($input, $alternative_values = null) {
        $this->digitalRootModel = new digitalRoot($input, $alternative_values);
    
        // $digitalRootModel->cutInputForNumeric();

        $this->digitalRootModel->cutInputForNumericLetters();

        $this->digitalRootModel->explodeInput();

        $this->digitalRootModel->convertLettersToNumbers();

        $this->digitalRootModel->calculateDigits();
    }

    public function getDigitalRoot($input, $alternative_values = null)
    {
        $this->buildSingleInstance($input, $alternative_values);

        return $this->digitalRootModel->getDigRoot();
    }

    public function getDigitalRootCompleteCalculation($input, $alternative_values = null) 
    {
        $this->buildSingleInstance($input, $alternative_values);

        return [
            'root' => $this->digitalRootModel->getDigRoot(),
            'digits' => $this->digitalRootModel->getDigRootCompCalc(),
            'numeric' => $this->digitalRootModel->getdigitalRootFullNumericResult()
        ];
    }

    public function getdigitalRootBulk($values, $alternative_values = null) {
        $returnData = [];

        foreach($values as $value) {
            $this->buildSingleInstance($value, $alternative_values);
            $returnData[$value] = $this->digitalRootModel->getDigRoot();
        }

        return $returnData;
    }
}

?>
