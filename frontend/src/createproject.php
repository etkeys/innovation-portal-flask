<?php 
    session_start(); 

    include 'php/singleviewfunctions.php';

    $prevCreateFailure = FALSE;
    if (@array_key_exists("prev-create-attempt-failure", $_SESSION)){
        $prevCreateFailure = TRUE;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    <link rel="stylesheet" type="text/css" href="css/create.css"/>
    <title>Innovation Portal - Create a Project</title>
<style>
    textarea.proj-desc-input{
        height: 9vw;
        width: 100%;
    }
</style>
</head>

<body>

    <?php include 'php/headers/mainbanner.php'; include 'php/navbars/mainnav.php'; ?>


    <?php
        if ($prevCreateFailure){
                echo "<div class=\"boxed-message\">
                        <div class=\"message-type-bad\">
                            <p>Could not create project. Project may already exist or fields may not have been filed out correctly.</p>
                        </div>
                    </div>
                    <br/>";
            unset($_SESSION["prev-create-attempt-failure"]);
        }
    ?>
    <div class="maincontent">
        <div class="subcontent">
            <h1>Create a New Project</h1>
            <header><h3>Enter initial project information</h3></header>
            <p>Need more fields? Additional project details can be filled in
                once the project is created.</p>
            <form action="createproject.php?operation=create" method="post">
                <input type="text" name="projectTitle" placeholder="Project title" autofocus>
                <textarea class="proj-desc-input" name="projectDescription"
                            placeholder="Project short description (255 character limit) ... (you can provide a more detailed synopsis later)"></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>