<?php

use PHPUnit\Framework\TestCase;
use digitalRootSrc\digitalRootBuilder;
use digitalRootSrc\digitalRoot;

final class digitalRootTest extends TestCase
{
    /**
     * testDigitalRoot
     *
     * @return void
     */
    public function testDigitalRoot(): void
    {
        $this->assertEquals([
            'client_input' => '23081996',
            'digital_root' => '2'
        ], digitalRootBuilder::getDigitalRoot('23081996'));
    }

    /**
     * testDigitalRootCompleteCalculation
     *
     * @return void
     */
    public function testDigitalRootCompleteCalculation(): void
    {
        $this->assertEquals([
            'client_input' => '299493218',
            'digital_root' => 2,
            'full_calculation' => [2, 9, 11, 1, 1, 2, 9, 11, 1, 1, 2, 4, 6, 9, 15, 1, 5, 6, 3, 9, 2, 11, 1, 1, 2, 1, 3, 8, 11, 1, 1, 2]
        ], digitalRootBuilder::getDigitalRootCompleteCalculation('299493218'));
    }

    /**
     * testDigitalRootBulk
     *
     * @return void
     */
    public function testDigitalRootBulk(): void
    {
        $this->assertEquals([
            '23081996' => '2',
            '43434336' => '3'
        ], digitalRootBuilder::getdigitalRootBulk(['23081996', '43434336']));
    }

    /**
     * testDigitalRootBulkAlternativeValues
     *
     * @return void
     */
    public function testDigitalRootBulkAlternativeValues(): void
    {
        $this->assertEquals([
            'abc27' => '6',
            'bbc92' => '9'
        ], digitalRootBuilder::getdigitalRootBulk(['abc27', 'bbc92'], ['A' => 1, 'B' => 2, 'C' => 3]));
    }

    /**
     * testDigitalRootLetters
     *
     * @return void
     */
    public function testDigitalRootLetters(): void
    {
        $this->assertEquals([
            'client_input' => 'a,..,b',
            'digital_root' => '3'
        ], digitalRootBuilder::getDigitalRoot('a,..,b'));
    }

    /**
     * testDigitalRootAlternativeLetters
     *
     * @return void
     */
    public function testDigitalRootAlternativeLetters(): void
    {
        $this->assertEquals([
            'client_input' => 'abc12',
            'digital_root' => '9'
        ], digitalRootBuilder::getDigitalRoot('abc12', ['A' => 1, 'B' => 2, 'C' => 3]));
    }

    /**
     * testDigitalRootAlternativeLettersFullCalc
     *
     * @return void
     */
    public function testDigitalRootAlternativeLettersFullCalc(): void
    {
        $this->assertEquals([
            'client_input' => 'abc12',
            'digital_root' => '9',
            'full_calculation' => [1, 2, 3, 3, 6, 1, 7, 2, 9]
        ], digitalRootBuilder::getDigitalRootCompleteCalculation('abc12', ['A' => 1, 'B' => 2, 'C' => 3]));
    }
}
