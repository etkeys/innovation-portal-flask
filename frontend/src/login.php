<?php 
    session_start(); 
  
    if (@array_key_exists("userdef",$_SESSION)){
        header("Location: index.php");
    }

    include_once "php/loginlogout.php";

    $prevAttemptFailure = "none";
    if (@array_key_exists("prev-attempt-failure", $_SESSION)){
        $prevAttemptFailure = $_SESSION["prev-attempt-failure"];
    }

    unset($_POST);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />  
    <link rel="stylesheet" type="text/css" href="css/login.css"/>
    <title>Innovation Portal - Login</title>
</head>

<body>

    <?php include 'php/headers/mainbanner.php'; include 'php/navbars/mainnav.php'; ?>

    <div class="maincontent">
        <div class="subcontent">
            <h1>Log In / Register</h1>
            <?php
                if ($prevAttemptFailure === 'login'){
                        echo "<div class=\"boxed-message\">
                                <div class=\"message-type-bad\">
                                    <p>Incorrect username or password</p>
                                </div>
                            </div>
                            <br/>";
                }

                switch($prevAttemptFailure){
                    case "login-request":
                        echo "<div class=\"boxed-message\">
                                <div class=\"message-type-bad\">
                                    <p>Incorrect email or password</p>
                                </div>
                            </div>
                            <br/>";
                        break;
                    case "register-request":
                        echo "<div class=\"boxed-message\">
                                <div class=\"message-type-bad\">
                                    <p>Could not use requested email. please user a different one.</p>
                                </div>
                            </div>
                            <br/>";
                        break;
                }
            
                $prevAttemptFailure = "";

            ?>
            <div class="user-login">
                <header><h3>Returning Member Login</h3></header>
                <form action="login.php?operation=login-request" method="post">
                    <input type="text" name="username" placeholder="Email" autofocus>
                    <input type="password" name="password" placeholder="Password">
                    <button type="submit">Log In</button>
                </form>
            </div>
            <div class="user-login">
                <header><h3>New Member Registration</h3></header>
                <p class="message-fields-required">Please fill out all fields.</p>
                <form action="login.php?operation=register-request" method="post">
                    <input type="text" name="username" placeholder="Email">
                    <input type="password" name="password" placeholder="Password">
                    <input type="text" name="firstName" placeholder="First name">
                    <input type="text" name="lastName" placeholder="Last name">
                    <input type="text" name="displayName" placeholder="Display name">

                    <button type="submit">Register</button>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>