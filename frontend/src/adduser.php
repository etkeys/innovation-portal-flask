<?php 
    include_once 'php/errorhandling.php';

    if (file_exists('php/mock/mock-jamcomm.php')){
        include_once 'php/mock/mock-jamcomm.php';
    }else{
        include_once 'php/jamcomm.php';
    }

    $request = array( "request" => "project-add-user",
                    "email" => $_GET["email"],
                    "project_id" => $_GET["project_id"]);

    $response = SendBackendRequestAwait($request);

    if ($response["response"] != "OK"){
        RedirectIfResponseIsBad($response);
    }
    
    echo "<script>
        alert('User has been successfully added!');
        </script>";

    header("Location: singleview.php?project_id=".$_GET["project_id"]);

?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    <link rel="stylesheet" type="text/css" href="css/landing.css" />
    <title>Innovation Portal</title>
</head>

<body>

    <?php include 'php/headers/mainbanner.php'; include 'php/navbars/mainnav.php'; ?>
    
</body>

</html>