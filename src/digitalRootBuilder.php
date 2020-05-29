<?php

namespace digitalRootSrc;

use digitalRootSrc\digitalRoot;
use digitalRootSrc\inputWorker;

class digitalRootBuilder
{
    /**
     * Returns single digitalRoot instance.
     *
     * @param  mixed $input
     * @param  mixed $alternative_values
     * @return digitalRoot
     */
    private static function buildSingleInstance(string $input, array $alternative_values = null): digitalRoot
    {
        $inputWorker = new inputWorker($input, $alternative_values);

        return (new digitalRoot($inputWorker));
    }

    /**
     * getDigitalRoot
     *
     * @param  mixed $input
     * @param  mixed $alternative_values
     * @return array
     */
    public static function getDigitalRoot(string $input, array $alternative_values = null): array
    {
        $digitalRootModel = digitalRootBuilder::buildSingleInstance($input, $alternative_values);

        $digitalRootModel->shortCalculation();

        return [
            'client_input' => $digitalRootModel->getOrigInput(),
            'digital_root' => $digitalRootModel->getDigRoot()
        ];
    }

    /**
     * getDigitalRootCompleteCalculation
     *
     * @param  mixed $input
     * @param  mixed $alternative_values
     * @return array
     */
    public static function getDigitalRootCompleteCalculation(string $input, array $alternative_values = null): array
    {
        $digitalRootModel = digitalRootBuilder::buildSingleInstance($input, $alternative_values);

        $digitalRootModel->longCalculation();

        return [
            'client_input' => $digitalRootModel->getOrigInput(),
            'digital_root' => $digitalRootModel->getDigRoot(),
            'full_calculation' => $digitalRootModel->getDigRootFullCalculation()
        ];
    }

    /**
     * getdigitalRootBulk
     *
     * @param  mixed $values
     * @param  mixed $alternative_values
     * @return array
     */
    public static function getdigitalRootBulk(array $values, array $alternative_values = null): array
    {
        $returnData = [];

        foreach ($values as $value) {
            $digitalRootModel = digitalRootBuilder::buildSingleInstance($value, $alternative_values);
            $digitalRootModel->shortCalculation();
            $returnData[$value] = $digitalRootModel->getDigRoot();
        }

        return $returnData;
    }
}
