<?php

use PHPUnit\Framework\TestCase;
use digitalRootSrc\digitalRootBuilder;

final class digitalRootTest extends TestCase {
    public function testdigitalRootFinal() : void {
        $this->assertEquals("2", (new digitalRootBuilder)->getDigitalRoot("23081996"));
    }

    public function testdigitalRootFull() : void {
        $this->assertEquals([
            'digits' => [2,5,5,4,5,5,5,2],
            'numeric' => '25545552'
        ], 
        (new digitalRootBuilder)->getdigitalRootFullResult("23081996"));
    }

    public function testdigitalRootBulk() : void {
        $this->assertEquals([
            '23081996' => '2',
            '43434336' => '3'
        ],
        (new digitalRootBuilder)->getdigitalRootBulkResult(['23081996','43434336']));
    }

    public function testdigitalRootFinalLetters() : void {
        $this->assertEquals("3", (new digitalRootBuilder)->getDigitalRoot("a,..,b"));
    }

}