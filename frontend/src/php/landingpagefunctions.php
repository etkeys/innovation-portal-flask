<?php
include_once 'php/errorhandling.php';

if (file_exists('php/mock/mock-jamcomm.php')){
    include_once 'php/mock/mock-jamcomm.php';
}else{
    include_once 'php/jamcomm.php';
}

$project_template = file_get_contents('templates/landing-page-project.html');

function FetchContent($theContentType){

    $request = array();
    $response = array();

    switch($theContentType){
        case "featured":
            $request = GetRequestArrayFeatured();
            break;
        case "requesting-moderator":
            $request = GetRequestArrayRequestingModerator();
            break;
        case "simple-search":
            $request = GetRequestArraySimpleSearch();
            break;
        case "frequently-viewed":
            $request = GetRequestArrayViewed();
            break;
        case "newlyadded":
            $request = GetRequestArrayNewlyAdded();
            break;
        case "my-project":
            $request = GetRequestArrayMyProject();
            break;
        case "admin-view-all":
		    $request = GetRequestedArrayViewAll();
	        break;
        default:
            $request = GetRequestArrayNoContent();
            break;
    }

    $response = SendBackendRequestAwait($request);

    if ($response["response"] != "OK"){
        RedirectIfResponseIsBad($response);
    }

    if (in_array($theContentType, array("frequently-viewed", "newlyadded"))){
        $response = SortResponse($response);
    }
    
    return $response;   
}

function GetRequestArrayFeatured(){
    $result = array("request" => "fdc-featured");

    return $result;
}

function GetRequestArrayRequestingModerator(){
    $result = array("request" => "fdc-requesting-moderator");

    return $result;
}

function GetRequestArrayMyProject(){

	$creator = $_SESSION['userdef']['permissions']['creator'];
	$moderator = $_SESSION['userdef']['permissions']['moderator'];
	$participant = $_SESSION['userdef']['permissions']['participant'];
	$project = array_merge ($creator, $moderator, $participant); 
	$result = array("request" => "fdc-my-projects",
	"username"=> $_SESSION['userdef']['useremail'],
	"projects"=> $project);

	return $result;
}

function GetRequestArrayNewlyAdded(){
	$result = Array("request" => "fdc-newlyadded");
	
	return $result;
}

function GetRequestArrayNoContent(){
    $result = array("request" => "no-content-selected");

    return $result;
}

function GetRequestArraySimpleSearch(){
    $result = array("request" => "fdc-simple-search",
                    "filter" => $_GET["query"]);
    
    return $result;
}  

function GetRequestArrayViewed(){
	$result= Array("request"=> "fdc-frequently-viewed");
	
	return $result;		
}

function GetRequestedArrayViewAll(){
	$result = array ("request" => "fdc-admin-view-all");
	
	return $result;
	
	
}


function SortResponse($response){
    $result = array();

    //First we have to get all the keys that are not "project##"
    foreach($response as $key => $value){
        if (!preg_match('/^project\d+/',$key)){
            $result["$key"] = $value;
        }
    }

    //Now, we can get all the project values, in sorted order
    for($i = 0; $i < $response["count"]; $i++){
        $result["project$i"] = $response["project$i"];
    }

    return $result;
}

?>
