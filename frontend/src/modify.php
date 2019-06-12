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


	ini_set('error_reporting', E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
    	include_once 'php/errorhandling.php';
    
    	if (file_exists('php/mock/mock-jamcomm.php')){
        
        	include_once 'php/mock/mock-jamcomm.php';
    	}else{
        
        	include_once 'php/jamcomm.php';
    	}

	$file_name = $_POST["filename"];
	$file_directory = 'resources/uploads/' . $_GET["project_id"] . '/';
	$file = $file_directory . $file_name;
	$ext = pathinfo($file_name, PATHINFO_EXTENSION);
	
	$old_text = $_POST["oldtext"];
	$new_text = $_POST["newtext"];

	if($file_name == "")
	{
		echo '<script language="javascript">';
		echo 'alert("Please enter the name of the file that you want to modify.")';
		echo '</script>';
		exit;
	}
	if($old_text == "")
	{
		echo '<script language="javascript">';
		echo 'alert("Please enter the contents that you want to replace.")';
		echo '</script>';
		exit;
	}
	if($new_text == "")
	{
		echo '<script language="javascript">';
		echo 'alert("Please enter the new contents that you want to insert.")';
		echo '</script>';
		exit;
	}
	else
	{
		$search = scandir($file_directory);
	
		foreach($search as $value)
		{
			if($value == $file_name)
			{
				if($ext == "txt")
				{
					file_put_contents($file,str_replace($old_text,$new_text,file_get_contents($file)));
					echo '<script language="javascript">';
					echo 'alert("The contents of the file have been changed!")';
					echo '</script>';
					exit;
				}
				if($ext == "doc" || $ext == "docx")
				{
					$zip = new ZipArchive();
					
					$inputFile = $file;
					$outputFile = $file;
					
					if ($zip->open($file, ZipArchive::CREATE)!==TRUE) 
					{
    						echo '<script language="javascript">';
						echo 'alert("File could not be found!")';
						echo '</script>';
						exit;
					}
					
					$xml = $zip->getFromName('word/document.xml');
					$xml = str_replace($old_text, $new_text, $xml);

					if ($zip->addFromString('word/document.xml', $xml)) 
					{ 
						echo '<script language="javascript">';
						echo 'alert("The contents of the file have been changed!")';
						echo '</script>';
						exit; 
					}
					else 
					{
						echo '<script language="javascript">';
						echo 'alert("File contents could not be written!")';
						echo '</script>';
						exit; 
					}
					$zip->close();
				}
			}
		}
		if($search == FALSE)
		{
			echo '<script language="javascript">';
			echo 'alert("File directory could not be found!")';
			echo '</script>';
			exit;
		}
		else
		{
			echo '<script language="javascript">';
			echo 'alert("File could not be found!")';
			echo '</script>';
			exit;
		}
	}
?>
</body>
</html>