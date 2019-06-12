<!DOCTYPE html>
<html>
<head>
	<title>Innovation Portal Artifact Upload</title>
	<link rel="stylesheet" type="text/css" href="css/global.css" />
    
	<link rel="stylesheet" type="text/css" href="css/banner-nav.css" />
    
	<link rel="stylesheet" type="text/css" href="css/landing.css" />

</head>
<body>
<?php
        
	include 'php/headers/mainbanner.php';
        
	include 'php/navbars/mainnav.php';
    
	$location = "upload.php?project_id=" . $_GET["project_id"];


    echo "<form action=" . $location . " method=\"POST\" enctype=\"multipart/form-data\">"
?>
    <h2 style ="text-align:center"> Upload Artifact </h2>
    <p style ="text-align:center"> Please choose the Artifacts you would like to upload. </p><br>
    <input type="checkbox" name="thumbnail" id="thumbnail" value="Yes"/> Is this a thumbnail?<br>
    <input type="file" name="files" id="files"/> 
    <br><br>
    <input type="submit" value="Upload" name="submit"/>
</form>
<br><br>
<?php
echo "<form action=\"singleview.php?project_id='" . urlencode($_GET["project_id"]) . "' method=\"post\">
	<input type='submit' value='Cancel'>
</form>"
?>

</body>
</html>