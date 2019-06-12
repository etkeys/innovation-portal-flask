<!DOCTYPE html>
<html>
<head>
	<title>Innovation Portal Artifact Deletion</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
	<link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
	<link rel="stylesheet" type="text/css" href="css/landing.css" />
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
</head>
<style>
<?php

    $projectID = $_GET["project_id"];
    $dir="resources/uploads/" . $projectID . "/";
    $array = scandir($dir);

?>
	.wrapperFILE {
        display: grid;
		grid-gap: 5%;
        grid-template-columns: 40% 35% 10%;
    }

    .box {
        background-color: #333;
        color: white;
        border-radius: 5px;
        padding: 20px;
        font-size: 125%;

    }

    .a {
        grid-column: 1 / span 2;
    }
    .b {
        grid-column: 3 ;
        grid-row: <?php echo count($array);?>;
		text-align:center;
    }
	.d {
		text-align:center;
	}
</style>
<body>
<?php
        
	include 'php/headers/mainbanner.php';
        
	include 'php/navbars/mainnav.php';

	$projectID = $_GET["project_id"];
	$location = "delete.php?project_id=" . $projectID;
	
	echo "<h2 style=\"text-align:center;\"> Delete Artifacts</h2>";
	echo "<p style=\"text-align:center;\"> Please choose the Artifacts you would like to remove </p><br>";
	echo "<form action=" . $location . " method=\"POST\" enctype=\"multipart/form-data\">";
	echo "<div class =\"wrapperFILE\">";
	
	$dir="resources/uploads/" . $projectID . "/";
	//$dir="resources/uploads/1/"; // test value
	
	//$array = scandir($dir); Moved to before style
	
	$array = scandir($dir);
	$i=0;
	if(count($array) > 0){
    	foreach($array as $value){
    	    if($value<>"." and $value<>".."){
    	        echo "<div class=\"box a\">" . $value . "</div>";
    	        echo "<div class=\"box d\">";
    	        echo "     <input type=\"checkbox\" name=\"artifact" . $i . "\" id=\"artifact" . $i . "\" value=\"" .$value . "\"/> </input>";
    	        echo "</div>";
    	        $i++;
    	    }
    	}
	}
	
	if($i==0){
	    echo "<div class=\"box a\">NONE</div>";
	}
	if($i==0){
	    echo "<div class=\"box d\">";
	    echo "     <input type=\"submit\" value=\"Delete\" name=\"submit\" disabled/>";
	}else{
	    echo "<div class=\"box b\">";
	    echo "     <input type=\"submit\" value=\"Delete\" name=\"submit\"/>";
	}
	echo "</div>";
	echo "</div>";
?>
	</div>
</form>

</body>
</html>