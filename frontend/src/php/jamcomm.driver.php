<?php

/*This is just a testing driver for development only*/

include('jamcomm.php');

$someData = array(
    "Name" => "John.Doe",
    "Message" => "Hello world!"
);

$response = SendBackendRequestAwait($someData);
//print_r($response);

?>