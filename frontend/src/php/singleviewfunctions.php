<?php
include_once 'php/errorhandling.php';

if (file_exists('php/mock/mock-jamcomm.php')){
    include_once 'php/mock/mock-jamcomm.php';
}else{
    include_once 'php/jamcomm.php';
}

$project_template = file_get_contents('templates/single-project-view.html');

if (@array_key_exists("operation", $_GET) And ($_GET["operation"] === "create")){
    CreateProject();
}

function CreateProject(){
    $request = array("request" => "create-project",
                        "creator" => $_SESSION["userdef"]["useremail"],
                        "project_name" => $_POST["projectTitle"],
                        "project_description" => $_POST["projectDescription"]);

    $response = SendBackendRequestAwait($request);

    //print_r($response);

    if ($response["response"] != "OK"){
        $_SESSION["whoopsie"] = $response["exception-details"];
        header("Location: whoopsie.php");
        exit;
    }

    if (@array_key_exists("project_id", $response) And
        @is_numeric($response["project_id"])) {
        
            array_push($_SESSION["userdef"]["permissions"]["creator"],$response["project_id"]);

            header("Location: singleview.php?project_id=$response[project_id]");
            exit;
    }else{
        $_SESSION["prev-create-attempt-failure"] = TRUE;
        header("Location: createproject.php?create=true");
        exit;
    }    
}

function FetchContent($project_id){

    $request = array();
    $response = array();

    $request = array( "request" => "single-project",
                    "project_id" => $project_id);

    $response = SendBackendRequestAwait($request);
    
    //echo implode(" ", $response);
    //echo implode("|",$response);

    if ($response["response"] != "OK"){
        RedirectIfResponseIsBad($response);
    }
    
    return $response;
}

function getUserProjectAssociation($project_id){
    // TO DO: Actually get the user's project association
    
    if (!@array_key_exists("userdef", $_SESSION)) {
        return PROJECT_ASSOCIATION_NONE;
    }
    
    $specialUserFlag = "notspecial";
    
    if (@array_key_exists("specialUserFlag", $_SESSION["userdef"]["permissions"])){
            $specialUserFlag = $_SESSION["userdef"]["permissions"]["specialUserFlag"];
    }
    
    if ($specialUserFlag === "administrator") {
        return PROJECT_ASSOCIATION_ADMIN;
    }
    
    if ($specialUserFlag === "tester") {
        return PROJECT_ASSOCIATION_TESTER;
    }
    
    if (in_array($project_id, $_SESSION['userdef']['permissions']['creator'])) {
        return PROJECT_ASSOCIATION_CREATOR;
    }
    
    if (in_array($project_id, $_SESSION['userdef']['permissions']['moderator'])) {
        return PROJECT_ASSOCIATION_MODERATOR;
    }
    
    if (in_array($project_id, $_SESSION['userdef']['permissions']['participant'])) {
        return PROJECT_ASSOCIATION_PARTICIPANT;
    }
}

?>