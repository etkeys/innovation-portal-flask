<?php 
    session_start(); 

    include_once 'php/landingpagefunctions.php';
    include_once 'php/templating.php';

    if (!@array_key_exists("content", $_GET)){
        header("Location: index.php?content=featured");
        exit;
    }else{
        $validContentTypes = array("featured",
                                    "simple-search",
                                    "requesting-moderator",
                                    "frequently-viewed",
									"my-project",
                                    "newlyadded",
                                    "admin-view-all");
                                    
        RedirectIfInvalidContentType($_GET["content"], $validContentTypes);
        
        //$pageContent = FetchContent($_GET["content"]);
        //$pageContent = GetFilledTemplate("templates/landing-page-project.html", $pageContent);
		
		

	 if (($_GET['content']) == 'my-project' && (array_key_exists('username', $_SESSION['userdef']))) {
		  $pageContent = FetchContent($_GET["content"]);
		  $CreatorProject = GetFilledTemplateMyProjectCreator("templates/landing-page-projectcreator.html", $pageContent);
		  $ModeratorProject = GetFilledTemplateMyProjectModerator("templates/landing-page-projectmoderator.html", $pageContent);
		  $ParticipantProject = GetFilledTemplateMyProjectParticipant("templates/landing-page-projectparticipant.html", $pageContent);
		  
		  $pageContent = ''.$CreatorProject.''.$ModeratorProject.''.$ParticipantProject;
	
	 } 
	 
	 elseif (($_GET['content']) == 'admin-view-all' && $_SESSION['userdef']['permissions']['specialUserFlag'] == 'administrator') {
		
			$tableheader = '<table class="adminprojects">
				<tr>
				<th> Project ID </th>
				<th> Project Name </th>
				<th> Mentor Name </th>
				</tr>';
			$pageContent = FetchContent($_GET["content"]);
			$pageContent = $tableheader . GetFilledTemplateViewAllProject("templates/landing-page-viewallproject.html", $pageContent) . '</table>';
			
		  
	  }
	  
	  elseif (($_GET['content']) == 'admin-view-all' && $_SESSION['userdef']['permissions']['specialUserFlag'] != 'administrator') {
			header("Location: index.php?content=featured");
			exit;
		  
	  }
	 elseif (($_GET['content']) == 'my-project' && (!array_key_exists('username', $_SESSION['userdef']))) {
            header("Location: index.php?content=featured");
            exit;
		 
	 }
	 else {
            $pageContent = FetchContent($_GET["content"]);
            $pageContent = GetFilledTemplate("templates/landing-page-project.html", $pageContent);
		 
	 }
		
    }
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    <link rel="stylesheet" type="text/css" href="css/landing.css" />
    <link rel="stylesheet" type="text/css" href="css/projectadmin.css" />
    
    <title>Innovation Portal</title>
</head>

<body>

    <?php
    
        include 'php/headers/mainbanner.php';
        include 'php/navbars/mainnav.php';
    
    ?>

    <div class="maincontent">
        <?php
            if($_GET["content"] == "newlyadded") {
                echo "<div class='row'><h1>Newly Added Projects</h1></div>";
            }
            else if($_GET["content"] == "my-project") {
                echo "<div class='row'><h1>My Projects</h1></div>";            
            }
            else if($_GET["content"] == "simple-search") {
                echo "<div class='row'><h1>Search Results for \"" . $_GET["query"] . "\"</h1></div>";            
            }
            else {
                echo "<div class='row'><h1>" . ucwords(str_replace("-", " ", $_GET["content"])) . " Projects</h1></div>";
            }
        ?>

        <div class="row">
            <?php   
                    echo $pageContent;  
            ?>
        </div>
    </div>
</body>

</html>