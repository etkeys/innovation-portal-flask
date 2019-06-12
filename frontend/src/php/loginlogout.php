<?php
    //session_start();
    include_once 'php/errorhandling.php';

    if (file_exists('php/mock/mock-jamcomm.php')){
        include_once 'php/mock/mock-jamcomm.php';
    }else{
        include_once 'php/jamcomm.php';
    }

    if(!@array_key_exists("operation", $_GET) Or 
        !@in_array($_GET["operation"], array("login", "login-request", "logout", "register-request"))){
        header("Location: index.php");
    }

    if ($_GET["operation"] === "logout"){
        session_unset();
        header("Location: index.php");
    }

    if (@in_array($_GET["operation"], array("login-request", "register-request"))){

        if (@array_key_exists("prev-attempt-failure", $_SESSION)){
            unset($_SESSION["prev-attempt-failure"]);
        }

        $request = GetRequestArray($_GET["operation"]);

        $response = SendBackendRequestAwait($request);

        //print_r($response);

        if ($response["response"] != "OK"){
            RedirectIfResponseIsBad($response);

        }elseif(empty($response["userdef"])){
            $_SESSION["prev-attempt-failure"] = $_GET["operation"];

            header("Location: login.php?operation=login");
        }else{
            $_SESSION["userdef"] = $response["userdef"];
            header("Location: index.php");
        }
        
    }

function GetRequestArray($operation){
    $result = array();
    switch($operation){
        case "login-request":
            $result = array("request" => "login",
                            "credentials" => $_POST);
            break;
        case "register-request":
            $result = array("request" => "register",
                            "username" => "$_POST[username]",
                            "password" => "$_POST[password]",
                            "userdisplayname" => "$_POST[displayName]",
                            "first-name" => "$_POST[firstName]",
                            "last-name" => "$_POST[lastName]");
            break;
        default:
            $requst = array("request" => "unknown-or-bad-operation",
                            "type" => $operation);
    }

    return $result;
}

?>
