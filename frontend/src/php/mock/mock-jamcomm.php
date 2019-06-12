<?php

include 'php/jamcomm.logging.php';
include 'php/utils.php';

function SendBackendRequestAwait($request){
    $response = array();

    PrintArrayToLogFile($request, "Request (mock/jamcomm.php)");

    switch($request["request"]){
        case "create-project":
            $response = GetResponseCreateProject($request); break;

        case "fdc-featured":
        case "fdc-frequently-viewed":
        case "fdc-requesting-moderator":
        case "fdc-simple-search":
            $response = GetResponseFillDisplayCase($request); break;
        
        case "login":
            $response = GetResponseLogin($request); break;

        case "register":
            $response = GetResponseRegister($request); break;

        case "single-project":
            $response = GetSampleResponseSingle($request); break;

        case "artifact_upload":
            $response = GetResponseArtifactUpload($request); break;
        
        case "joinRequest":
            $response = GetResponseRequestJoin($request);
            break;
            
        case "artifact_delete":
            $response = GetResponseArtifactDelete($request);
            break;


        default:
            $response = GetResponseFail(); break;
    }

    PrintArrayToLogFile($response, "Response (mock/jamcomm.php)");

    return $response;
}

function GetRandomJsonFileFromDir($pathOfDir){
    $files = array_diff(scandir($pathOfDir), array('.', '..'));
    $afile = $files[rand(2, count($files) + 1)];
    $json = file_get_contents("$pathOfDir/$afile");
    $result = JsonToAssociativeArray($json);
    
    return $result;
}

function GetResponseCreateProject($theRequest){
    $path = "php/mock/json-responses/create-project/$theRequest[project_name].json";
    $json = file_get_contents($path);
    $result = JsonToAssociativeArray($json);
    
    return $result;
}

function GetResponseFail(){
    $e = new \Exception;
    $result = array( "response" => "frontend-exception",
            "exception-details" => array(
            "message" => "mock-jamcomm.php FailResponse",
            "number" => 1,
            "stack-trace" => $e->getTraceAsString())
            );

    return $result;
}

function GetResponseFillDisplayCase($theRequest){
    $type = @array_key_exists("filter", $theRequest) ?
                $theRequest["filter"] : $theRequest["request"];
                
    $path = "php/mock/json-responses/$type";
    $files = array_diff(scandir($path), array('.','..'));
    
    $afile = $files[rand(2, count($files) + 1)];
    $json = file_get_contents("$path/$afile");
    $result = JsonToAssociativeArray($json);

    return $result;
}

function GetSampleResponseSingle($theRequest){
    $type = $theRequest["project_id"];
    $path = "php/mock/json-responses/$type";
    $files = array_diff(scandir($path), array('.','..'));
    
    $afile = $files[2];
    $json = file_get_contents("$path/$afile");

    $result = JsonToAssociativeArray($json);

    return $result;
}

function GetResponseLogin($theRequest){
    $credetials = $theRequest["credentials"];
    $noUserDefFile = "php/mock/json-responses/mock-shared/no-user-def.json";

    //print_r($credetials);
    if (endsWith("$credetials[username]", '~')){
        $targetFile = "php/mock/json-responses/login/$credetials[username].json";
        printf($targetFile);

        if (file_exists("$targetFile")){
            $json = file_get_contents("$targetFile");
        }else{
            $json = file_get_contents("$noUserDefFile");
        }
            
    }elseif(endsWith("$credetials[username]", '!')){
        $json = file_get_contents("$noUserDefFile");

    }elseif("$credetials[username]" != "$credetials[password]"){
        $json = file_get_contents("$noUserDefFile");

    }else{
        $json =
            file_get_contents("php/mock/json-responses/login/$credetials[username].json");
    }

    $result = JsonToAssociativeArray($json);

    return $result;
}

function GetResponseRegister($theRequest){
    //print_r($theRequest);
    $noUserDefFile = "php/mock/json-responses/mock-shared/no-user-def.json";

    $targetFile = "php/mock/json-responses/register/$theRequest[username].json";
    
    if (file_exists("$targetFile")){
        $json = file_get_contents("$targetFile");
    }else{
        $json = file_get_contents("$noUserDefFile");
    }

    $result = JsonToAssociativeArray($json);

    return $result;
}

function GetResponseArtifactUpload($theRequest){
    $path = "php/mock/json-responses/uploads/uploads.json";
    if (file_exists($path)){
    	$json = file_get_contents($path);
    }
    else{
        $json = '{ "response": "NO" }';
    }

    $result = JsonToAssociativeArray($json);

    return $result;
}
function GetResponseArtifactDelete($theRequest){
    $path = "php/mock/json-responses/delete/deletions.json";
    if (file_exists($path)){
        $json = file_get_contents($path);
    }
    else{
        $json = '{ "response": "NO" }';
    }
    
    $result = JsonToAssociativeArray($json);
    
    return $result;
}

function GetResponseRequestJoin($theRequest){
    $path = "php/mock/json-responses/joinRequest/joinRequest.json";
    
    $json = file_get_contents("$path");

    $result = JsonToAssociativeArray($json);

    return $result;
}

?>