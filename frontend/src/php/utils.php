<?php

define("PROJECT_ASSOCIATION_NONE", 0);
define("PROJECT_ASSOCIATION_PARTICIPANT", 1);
define("PROJECT_ASSOCIATION_CREATOR", 2);
define("PROJECT_ASSOCIATION_MODERATOR", 3);
define("PROJECT_ASSOCIATION_ADMIN", 4);
define("PROJECT_ASSOCIATION_TESTER", 5);

function AssociativeArrayToJson($theArray){
    return json_encode($theArray);
}

function endsWith($haystack, $needle){
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}

function FormatFrontEndException($exception){
    $exceptionDetails = array(
        "response" => "frontend-exception", 
        "exception-details" => array(
		    "message" => $exception->getMessage(),
		    "number" => $exception->getCode(),
		    "file" => $exception->getFile(),
		    "line" => $exception->getLine(),
            "stack-trace" => $exception->getTraceAsString()	)
    );

	return $exceptionDetails;
}

function GetCustomIniValue($keyName){
    $CUSTOM_INI_FILE = 'ip-php-custom.ini';

    $result = parse_ini_file($CUSTOM_INI_FILE);

    if(array_key_exists($keyName, $result) && !is_null($result[$keyName])){
        $result = $result[$keyName];
    }else{
        $result = '';
    }
    
    return $result;
}

function JsonToAssociativeArray($theJson){
    return json_decode($theJson, TRUE);
}

function startsWith($haystack, $needle){
    $length = strlen($needle);
    return (substr($haystack, 0, $length) === $needle);
}
?>