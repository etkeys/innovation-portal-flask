<?php
    session_start();

    $details = $_SESSION["whoopsie"];
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/global.css" />
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    <link rel="stylesheet" type="text/css" href="css/whoopsie.css" />
    <title>Innovation Portal - Page Error</title>
</head>

<body>
    <?php include 'php/headers/mainbanner.php'; include 'php/navbars/mainnav.php'; ?>

    <div class="maincontent">
        <div class="subcontent">
            <div class="whoopsie-details">
                <h1>Error processing request</h1>
                <h2>There was a problem processing your request.</h2>
                <p>
                    Number: <?php echo $details["number"]; ?>
                </p>
                <p>
                    Message: <?php echo $details["message"]; ?>
                </p>
                <p>
                    Stack trace: <?php echo $details["stack-trace"]; ?>
                </p>
                <p>
            </div>
        </div>
    </div>

</body>
</html>