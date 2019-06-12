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


	echo '<h2>Modify Artifact</h2>';

	echo '<form action="modify.php?project_id=' . urlencode($_GET["project_id"]) . '"; " method="post">';
		echo 'Enter the name of the file:';
		echo '<br>';
		echo '<input type="text" name="filename"></input>';
		echo '<br><br>';
		echo 'Enter the old text that you want to replace:';
		echo '<br>';
		echo '<textarea type="text" name="oldtext" style="width: 400px; height: 200px"></textarea>';
		echo '<br><br>';
		echo 'Enter the new text that you want to use to replace the old text:';
		echo '<br>';
		echo '<textarea type="text" name="newtext" style="width: 400px; height: 200px"></textarea>';
		echo '<br><br>';
		echo '<input type="submit">';
	echo '</form>';
	echo '<br><br>';
	echo '<form action="singleview.php?project_id=' . urlencode($_GET["project_id"]) . '" method="post">';
		echo '<input type="submit" value="Cancel">';
	echo '</form>';
?>
</body>
</html>