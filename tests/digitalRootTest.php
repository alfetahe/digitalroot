<?php

use PHPUnit\Framework\TestCase;
use digitalRootSrc\digitalRootBuilder;

final class digitalRootTest extends TestCase {
    public function testDigitalRoot() : void {
        $this->assertEquals([
            'client_input' => '23081996',
            'digital_root' => '2'
        ], (new digitalRootBuilder)->getDigitalRoot('23081996'));
    }

    public function testDigitalRootCompleteCalculation() : void {
        $this->assertEquals([
            'client_input' => '299493218',
            'digital_root' => 2,
            'full_calculation' => [
                'string' => '2 9 11 1 1 2 9 11 1 1 2 4 6 9 15 1 5 6 3 9 2 11 1 1 2 1 3 8 11 1 1 2',
                'array' => [2,9,11,1,1,2,9,11,1,1,2,4,6,9,15,1,5,6,3,9,2,11,1,1,2,1,3,8,11,1,1,2]
            ],
            'single_digit_summaries' => [
                'string' => '6 9 3',
                'array' => [6,9,3]
            ],
            'double_digit_summaries' => [
                'string' => '11 11 15 11 11',
                'array' => [11,11,15,11,11]
            ],
            'double_digit_summaries_separated_digits' => [
                'string' => '1 1 1 1 1 5 1 1 1 1',
                'array' => [1,1,1,1,1,5,1,1,1,1]
            ],
            'double_digit_summaries_separated_digits_summaries' => [
                'string' => '2 2 6 2 2',
                'array' => [2,2,6,2,2]
            ],
        ], (new digitalRootBuilder)->getDigitalRootCompleteCalculation('299493218'));
    }

    public function testDigitalRootBulk() : void {
        $this->assertEquals([
            '23081996' => '2',
            '43434336' => '3'
        ], (new digitalRootBuilder)->getdigitalRootBulk(['23081996','43434336']));
    }

    public function testDigitalRootLetters() : void {
        $this->assertEquals([
            'client_input' => 'a,..,b',
            'digital_root' => '3'
        ], (new digitalRootBuilder)->getDigitalRoot('a,..,b'));
    }

    public function testDigitalRootAlternativeLetters() : void {
        $this->assertEquals([
            'client_input' => 'abc12',
            'digital_root' => '9'
        ], (new digitalRootBuilder)->getDigitalRoot('abc12', ['A' => 1, 'B' => 2, 'C' => 3]));
    }

}