<?php

use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase{
    public function testTrueAssertsTrue(){
        $this->assertTrue(true);
        //$this->assertTrue(false); //This will report as a failure
    }
}

?>