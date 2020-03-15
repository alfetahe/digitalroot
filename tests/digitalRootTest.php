<?php

use PHPUnit\Framework\TestCase;
use digitalRootSrc\digitalRootBuilder;

final class digitalRootTest extends TestCase {
    public function testdigitalRootFinal() : void {
        $this->assertEquals("2", (new digitalRootBuilder)->getdigitalRootFinalResult("23081996"));
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
            '1996823' => '1117682',
            '1996832' => '1117692'
        ],
        (new digitalRootBuilder)->getdigitalRootBulkResult(['1996823','1996832']));
    }

    public function testdigitalRootFinalLetters() : void {
        $this->assertEquals("3", (new digitalRootBuilder)->getdigitalRootFinalResult("a,..,b"));
    }

}