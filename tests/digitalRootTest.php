<?php

use PHPUnit\Framework\TestCase;
use digitalRootSrc\digitalRootBuilder;

final class digitalRootTest extends TestCase {
    public function testDigitalRoot() : void {
        $this->assertEquals("2", (new digitalRootBuilder)->getDigitalRoot("23081996"));
    }

    public function testDigitalRootCompleteCalculation() : void {
        $this->assertEquals([
            'root' => '2',
            'digits' => [2,5,5,4,5,5,5,2],
            'numeric' => '25545552'
        ], 
        (new digitalRootBuilder)->getDigitalRootCompleteCalculation("23081996"));
    }

    public function testDigitalRootBulk() : void {
        $this->assertEquals([
            '23081996' => '2',
            '43434336' => '3'
        ],
        (new digitalRootBuilder)->getdigitalRootBulk(['23081996','43434336']));
    }

    public function testDigitalRootLetters() : void {
        $this->assertEquals("3", (new digitalRootBuilder)->getDigitalRoot("a,..,b"));
    }

    public function testDigitalRootAlternativeLetters() : void {
        $this->assertEquals("9", (new digitalRootBuilder)->getDigitalRoot("abc12", ["A" => 1, "B" => 2, "C" => 3]));
    }

}