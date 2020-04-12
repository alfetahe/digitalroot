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
    }

    public function getDigitalRoot($input, $alternative_values = null)
    {
        $this->buildSingleInstance($input, $alternative_values);

        $this->digitalRootModel->shortCalculation();

        return $this->digitalRootModel->getDigRoot();
    }

    public function getDigitalRootCompleteCalculation($input, $alternative_values = null) 
    {
        $this->buildSingleInstance($input, $alternative_values);
        
        $this->digitalRootModel->longCalculation();

        return [
            'client_input' => $this->digitalRootModel->getOrigInput(),
            'root' => $this->digitalRootModel->getDigRoot(),
            'digits' => $this->digitalRootModel->getDigRootCompCalc(),
            'numeric' => $this->digitalRootModel->getdigitalRootFullNumericResult()
        ];
    }

    public function getdigitalRootBulk($values, $alternative_values = null) {
        $returnData = [];

        foreach($values as $value) {
            $this->buildSingleInstance($value, $alternative_values);
            $this->digitalRootModel->shortCalculation();
            $returnData[$value] = $this->digitalRootModel->getDigRoot();
        }

        return $returnData;
    }
}

?>
