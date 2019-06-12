<?php

include 'php/utils.php';

function SendBackendRequestAwait($request){
    $response = array();

    if (@in_array($request["request"], array("fill-display-case"))){
        $response = GetSampleResponse($request);
    }else{
        $response = GetFailResponse();
    }

    return $response;
}

function GetSampleResponse($theRequest){
    $type = $theRequest["filter"];

    $path = "json-responses/$type";
    $files = array_diff(scandir($path), array('.','..'));
    
    $afile = $files[rand(2, count($files) + 1)];
    $json = file_get_contents("$path/$afile");
    $result = JsonToAssociativeArray($json);

    return $result;
}

function GetFailResponse(){
    $e = new \Exception;
    $result = array( "response" => "frontend-exception",
            "exception-details" => array(
            "message" => "mack-jamcomm.php FalResponse",
            "number" => 1,
            "stack-trace" => $e->getTraceAsString())
            );

    return $result;
}

?>