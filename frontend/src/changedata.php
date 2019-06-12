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
	$project_name = $_POST["projectname"];
	$project_description = $_POST["description"];
	$tags = $_POST["tags"];
	$project_tags = explode(',', $tags);

	//$request = array('request' => 'change_project_data', 'projectID' => $project_id, 'project_name' => $project_name, 'project_description' => $project_description, 'project_tags' => $project_tags);
	//$response = SendBackEndRequestAwait($request);
	
	if($project_name != "" || $project_description != "" || $project_tags[0] != "")
	{
		echo '<script language="javascript">';
		echo 'alert("The project metadata has been sucessfully changed!")';
		echo '</script>';
	}
	else
	{
		echo '<script language="javascript">';
		echo 'alert("Please enter the changes you want to make to the project metadata")';
		echo '</script>';
	}
?>

</body>
</html>