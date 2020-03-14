<?php

namespace App;

use App\Vortex;

class VortexBuilder {
    public $vortexModel;

    // Builds single vortex instance.
    private function buildSingleInstance($input) {
        $this->vortexModel = new Vortex($input);
    
        // $vortex->cutInputForNumeric();

        $this->vortexModel->cutInputForNumericLetters();

        $this->vortexModel->explodeInput();

        $this->vortexModel->convertLettersToNumbers();

        $this->vortexModel->calculateDigits();
    }

    public function getVortexFinalResult($input)
    {
        $this->buildSingleInstance($input);

        return $this->vortexModel->getVortexFinalResult();
    }

    public function getVortexFullResult($input) 
    {
        $this->buildSingleInstance($input);

        return [
            'digits' => $this->vortexModel->getVortexFullDigitsResult(),
            'numeric' => $this->vortexModel->getVortexFullNumericResult()
        ];
    }

    public function getVortexBulkResult($values) {
        $returnData = [];

        foreach($values as $value) {
            $this->buildSingleInstance($value);
            $returnData[$value] = $this->vortexModel->getVortexFullNumericResult();
        }

        return $returnData;
    }
}

?>
