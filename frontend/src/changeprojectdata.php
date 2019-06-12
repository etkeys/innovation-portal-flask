<?php 
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Innovation Portal</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
    
	<link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    
	<link rel="stylesheet" type="text/css" href="css/landing.css" />

</head>
<body>
<?php
        
	include 'php/headers/mainbanner.php';
	include 'php/navbars/mainnav.php';
    
    echo '<div class="maincontent"><div class="subcontent">';
	echo '<h2>Change Project Metadata</h2>';

	echo '<form action="changedata.php?project_id=' . urlencode($_GET["project_id"]) . '" method="post">';
		echo 'Change Project Title';
		echo '<br>';
		echo '<input type="text" name="projectname">';
		echo '<br><br>';
		echo 'Change Project Description';
		echo '<br>';
		echo '<textarea type="text" name="description" style="width: 400px; height: 200px"></textarea>';
		echo '<br><br>';
		echo 'Change Project Tags';
		echo '<br>';
		echo '<input type="text" name="tags">';
		echo '<br><br>';
		echo '<input type="submit">';
	echo '</form></div></div>';

?>

</body>
</html>