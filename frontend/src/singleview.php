<?php
    session_start();

    include 'php/singleviewfunctions.php';
    include_once 'php/templating.php';
    include_once 'php/utils.php';

    $isRegistered = @array_key_exists("userdef", $_SESSION);
    
    if (!@array_key_exists("project_id", $_GET)){
        header("Location: index.php");
        exit;
    }else{
        $pageContent = FetchContent($_GET["project_id"]);
        $projectName = $pageContent["project_name"];
        if(isset($_GET["upload_result"])) {
            if($_GET["upload_result"]) {
                echo "<script>alert('Your file was successfully uploaded!');</script>";
            }
            else {
                echo "<script>alert('There was an error uploading your file. Please try again.');</script>";                
            }
            
        }
        if(isset($_GET["delete_result"])) {
            if($_GET["delete_result"]) {
                echo "<script>alert('Your file was successfully deleted!');</script>";
            }
            else {
                echo "<script>alert('There was an error deleting your file. Please try again.');</script>";                
            }
        }        
        
        $pageContent = GetFilledTemplateSingle("templates/single-project-view.html", $pageContent);
        
        $collabContent = FetchContent($_GET["project_id"]);
        $collabContent = GetFilledTemplateSingle("templates/single-project-viewparticipant.html", $collabContent);
        
    }
    
    if(isset($_POST['contribute'])) {
        if (!$isRegistered) {
            header("Location: login.php?operation=login");
            exit;           
        }
        
        $request = array("request" => "joinRequest",
                        "requestor" => $_SESSION["userdef"]["useremail"],
                        "project" => $_GET["project_id"]);      
        
        
        $response = SendBackendRequestAwait($request);
        
        if ($response["response"] != "OK"){
            $_SESSION["whoopsie"] = $response["exception-details"];
            header("Location: whoopsie.php");
            exit;
        }   
        
        echo "<script>
        alert('Your request has been sent!');
        </script>";

    }

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/global.css"/>
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css"/>
    <link rel="stylesheet" type="text/css" href="css/projects.css"/>
    <link rel="stylesheet" type="text/css" href="css/singleview.css"/>
    <?php
        echo "<title>Innovation Portal - " . $projectName . "</title>"
    ?>
</head>
<body>

<?php
    include 'php/headers/mainbanner.php';
    include 'php/navbars/mainnav.php';
?>
    <div class="maincontent">
    <div class="row">
        <?php    
                echo  $pageContent;
        
        if (getUserProjectAssociation($_GET["project_id"]) == PROJECT_ASSOCIATION_TESTER) {
            echo $collabContent;
        }
        
        if(getUserProjectAssociation($_GET["project_id"]) < PROJECT_ASSOCIATION_PARTICIPANT Or getUserProjectAssociation($_GET["project_id"]) == PROJECT_ASSOCIATION_TESTER) {
            echo "<form method='post'>
            <button class='button-contribute' name='contribute'>Request To Contribute</button>
            </form>";
        }
        else {
            echo $collabContent;
        }
        
        echo "</div></div></div>";
        
        if(getUserProjectAssociation($_GET["project_id"]) >= PROJECT_ASSOCIATION_CREATOR) {
                echo "<div class='row'>
                        <div class='project'>
                            <h2> Project Manager </h2>
                            <form method='POST' action='changeprojectdata.php?project_id=" .
                urlencode($_GET["project_id"]) . "'>
                                            <button class='button-metadata' disabled>Change Project Metadata</button>
                            </form>
                            <button class='button-privacy' disabled>Change Project Privacy Settings</button>
                            <button class='button-moderator' disabled>Request Project Moderator</button>
                            <br>
                        </div>
                        </div>
                        <div class='row'>
                            <div class='artifacts'>
                            <!-- this section should probably be styled like index.php from commit f449f972 -->
                            <h2> Artifact Manager </h2>
                            <form method='POST' action='fileupload.php?project_id=" .
    urlencode($_GET["project_id"]) . "'>
                                <button class='button-upload'>Upload Artifacts</button>
                            </form>
			    <form method='POST' action='filemodify.php?project_id=" .
    urlencode($_GET["project_id"]) . "'>
                            	<button class='button-modify'>Modify Artifacts</button>
			    </form>
			    <form method='POST' action='filedelete.php?project_id=" .
    urlencode($_GET["project_id"]) . "'>
                            	<button class='button-delete'>Delete Artifacts</button>
			    </form>
                            </div>
                        </div>";
        }
    ?>
        
    </div>
    </div>
    </div>
</body>
</html>