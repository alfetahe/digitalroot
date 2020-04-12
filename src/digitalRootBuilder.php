<?php

namespace digitalRootSrc;

use digitalRootSrc\digitalRoot;

class digitalRootBuilder {
    public $digitalRootModel;

    // Builds single digitalRoot instance.
    private function buildSingleInstance($input, $alternative_values = null) {

        $this->digitalRootModel = new digitalRoot($input, $alternative_values);
    }

    public function getDigitalRoot($input, $alternative_values = null)
    {
        $this->buildSingleInstance($input, $alternative_values);

        $this->digitalRootModel->shortCalculation();

        return [
            'client_input' => $this->digitalRootModel->getOrigInput(),
            'digital_root' => $this->digitalRootModel->getDigRoot()
        ];
    }

    public function getDigitalRootCompleteCalculation($input, $alternative_values = null) 
    {
        $this->buildSingleInstance($input, $alternative_values);
        
        $this->digitalRootModel->longCalculation();

        return [
            'client_input' => $this->digitalRootModel->getOrigInput(),
            'digital_root' => $this->digitalRootModel->getDigRoot(),
            'full_calculation' => $this->digitalRootModel->getDigRootFullCalculation(),
            'single_digit_summaries' => $this->digitalRootModel->getSingleDigitSummaries(),
            'double_digit_summaries' => $this->digitalRootModel->getDoubleDigitSummaries(),
            'double_digit_summaries_separated_digits' => $this->digitalRootModel->getDigRootddsSeparated(),
            'double_digit_summaries_separated_digits_summaries' => $this->digitalRootModel->getDigRootddssSummaries(),
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
