<?php

function PrintArrayToLogFile($theArray, $strPrefix = ""){
    //$isFileWriteAllowed = TRUE;
    $isFileWriteAllowed = parse_ini_file('php/ip-php-custom.ini')["print-array-jam-messages-to-file"];
    
    if ($isFileWriteAllowed){
        $logFileFullName = sys_get_temp_dir() . '/' . parse_ini_file('php/ip-php-custom.ini')["print-array-jam-messages-to-file-name"];

        file_put_contents($logFileFullName,
                            sprintf("[%s] %s", date('Y-m-d h:i:s a'), $strPrefix) . PHP_EOL,
                            FILE_APPEND);
        file_put_contents($logFileFullName, print_r($theArray, true) . PHP_EOL,FILE_APPEND);
    }
}

function PrintJsonToLogFile($theJson, $strPrefix = ""){
    $isFileWriteAllowed = parse_ini_file('php/ip-php-custom.ini')["print-json-jam-messages-to-file"];
    
    if ($isFileWriteAllowed){
        $logFileFullName = sys_get_temp_dir() . '/' . parse_ini_file('php/ip-php-custom.ini')["print-json-jam-messages-to-file-name"];

        file_put_contents($logFileFullName,
                            sprintf("[%s] %s", date('Y-m-d h:i:s a'), $strPrefix) . PHP_EOL,
                            FILE_APPEND);
        file_put_contents($logFileFullName, $theJson . PHP_EOL,FILE_APPEND);
    }
}

?>