<?php


?>
<!DOCTYPE html>
<html>
<head>
	<title>Innovation Portal File Upload</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
    
	<link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    
	<link rel="stylesheet" type="text/css" href="css/landing.css" />

</head>
<body>
<?php
        
	include 'php/headers/mainbanner.php';
        
	include 'php/navbars/mainnav.php';
    
    ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    include_once 'php/errorhandling.php';
    
    if (file_exists('php/mock/mock-jamcomm.php')){
        
        include_once 'php/mock/mock-jamcomm.php';
    }else{
        
        include_once 'php/jamcomm.php';
    }
    
    $target_project = $_GET["project_id"];
    $header_loc = "Location: singleview.php?project_id=" . $target_project . "&delete_result=";
    
    $artifacts = [];
    $artifacts_ext = [];
    
    //gets all artifacts from post
    foreach ($_POST as $key => $value) {
        if(strpos($key, 'artifact') !== false){
            echo "Field ".htmlspecialchars($key)." is ".htmlspecialchars($value)."<br>";
            //add $value to array
            $artifacts[] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
            $artifacts_ext[] = $value;
        }
    }
    
    //check if artifacts is empty
    if(count($artifacts) > 0){
        $request = array('request' => 'artifact_delete',
            'projectID' => $target_project,
            'artifacts' => $artifacts);
        
        $response = SendBackendRequestAwait($request);
        
        //check if JAM failed to remove
        if ($response["response"] != "OK"){
            echo "Response failed";
            $_SESSION["whoopsie"] = $response["exception-details"];
            header("Location: whoopsie.php");
            exit;
        }
        else{ //else delete the file
            foreach($artifacts_ext as $value){
                $del = 'resources/uploads/' . $target_project . '/' . $value;
                if (is_file($del)){
                    unlink($del);
                    echo "Deleted file" . $value;
                }else{
                    echo "Not a file";
                }
            }
        }
    }else{
        echo "No artifacts";
        header($header_loc . "false");
    }
    header($header_loc . "true");
?>







