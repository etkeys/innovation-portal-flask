<?php
    session_start();
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
    
    //gets the project id from url
    $target_project = $_GET["project_id"];
    $header_loc = "Location: singleview.php?project_id=" . $target_project . "&upload_result=";
    if($target_project == NULL){
        
        echo "No project ID exists.";
    }
    else{
        //sets up the expected target file and directory
        $target_dir = 'resources/uploads/' . $target_project . '/';
        $target_file = $target_dir . basename($_FILES["files"]["name"]);
        $ext = pathinfo(basename($_FILES["files"]["name"]), PATHINFO_EXTENSION);
        $target_thumbnail = $target_dir . "thumbnail." . $ext;
        
        //check if directory exists
        //if not attempts to create one
        $create_dir=true;
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
            chmod($target_dir, 0777);
            if(!file_exists($target_dir)){
                echo "failed to create directory";
                $create_dir = false;
                header($header_loc . "false");
            }
        }
        
        $file_NOT_Exists = true;
        //if directory exists check if file exists
        if($create_dir){
            if(file_exists($target_file)){
                echo "File already exists";
                $file_NOT_Exists = false;
                header($header_loc . "false");
            }
        }
        
        //if file does not exist check file size
        $file_size_OK = true;
        if($file_NOT_Exists){
            $file_size = $_FILES['files']['size'] / 1000000000;
            $size_limit = ini_get('upload_max_filesize'); 
            if($file_size > $size_limit){
                echo "file too large";
                $file_size_OK = false;
                header($header_loc . "false");
            }
        }
        
        $file_no_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($_FILES["files"]["name"]));
        
        //if file size is ok
        if($file_size_OK){
            //try to send to jam
            $request;
            if(isset($_POST['thumbnail']) &&
                $_POST['thumbnail'] == 'Yes'){
                    
                echo "it is a thumbnail";
                $request = array('request' => 'artifact_upload',
                    'projectID' => $target_project,
                    'artifact-location' => $target_thumbnail,
                    'artifact-type' => 'thumbnail');
            }
            else{
                $request = array('request' => 'artifact_upload',
                    'projectID' => $target_project,
                    'artifact-location' => $target_file,
                    'artifact-type' => $file_no_ext);
            }
            
            $response = SendBackendRequestAwait($request);
            
            //if fails exit
            if ($response["response"] != "OK"){
                
                $_SESSION["whoopsie"] = $response["exception-details"];
                header("Location: whoopsie.php");
                exit;
            }
            else{ //else move the file
                if(isset($_POST['thumbnail']) &&
                    $_POST['thumbnail'] == 'Yes'){
                        
                    if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_thumbnail)) {
                        echo "The file :". $target_thumbnail . " has been uploaded.";
                        chmod($target_thumbnail, 0777);
                        header($header_loc . "true");
                    }
                    else {
                        header($header_loc . "false");
                    }
                }
                else{
                    if (move_uploaded_file($_FILES["files"]["tmp_name"], $target_file)) {
                        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                        chmod($target_file, 0777);
                        header($header_loc . "true");
                    }
                    else {
                        header($header_loc . "false");
                    }
                }
                ///uncomment this to instantly return to project page
                
                header($header_loc . "true");
            }
        }
    }
?>
