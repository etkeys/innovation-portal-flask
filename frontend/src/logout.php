<?php 
    session_start(); 


    if(!@array_key_exists("userdef", $_SESSION)){
        header("Location: index.php");
    }

    $_GET["operation"] = "logout";

    include "php/loginlogout.php";

    $_POST = array();
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    <link rel="stylesheet" type="text/css" href="css/landing.css" />
    <title>Innovation Portal - Log Out</title>
</head>

<body>

    <?php include 'php/headers/mainbanner.php'; include 'php/navbars/mainnav.php'; ?>

    <div>
        <h1>You have been logged out.</h1>
    </div>
    
</body>

</html>