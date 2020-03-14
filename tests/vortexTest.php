<?php

use PHPUnit\Framework\TestCase;
use VortexMathSrc\VortexBuilder;

final class VortexTest extends TestCase {
    public function testVortexFinal() : void {
        $this->assertEquals("2", (new VortexBuilder)->getVortexFinalResult("23081996"));
    }

    public function testVortexFull() : void {
        $this->assertEquals([
            'digits' => [2,5,5,4,5,5,5,2],
            'numeric' => '25545552'
        ], 
        (new VortexBuilder)->getVortexFullResult("23081996"));
    }

    public function testVortexBulk() : void {
        $this->assertEquals([
            '1996823' => '1117682',
            '1996832' => '1117692'
        ],
        (new VortexBuilder)->getVortexBulkResult(['1996823','1996832']));
    }

    public function testVortexFinalLetters() : void {
        $this->assertEquals("3", (new VortexBuilder)->getVortexFinalResult("a,..,b"));
    }

}