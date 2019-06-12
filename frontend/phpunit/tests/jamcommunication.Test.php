<?php

use PHPUnit\Framework\TestCase;

include('src/php/jamcommunication.php');

class JamCommunicationTest extends TestCase{

    /*
    protected function setUp(){
        $serverStartCommand='phpunit/tests/startJamMock.sh';
        exec($serverStartCommand);
    }
    */
    public function testSendBackendRequest_EmptyArgIsOkay(){
        try{
            $somearray = array();
            SendBackendRequest($somearray);
            $this->assertTrue(true);
        } catch (Throwable $t){
            printf("Error in call: %s", $t->getMessage());
            $this->assertTrue(false);
        }
        //$this->assertTrue(false); //This will report as a failure
    }
}

?>