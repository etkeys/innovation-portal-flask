<?php
    @session_start();
/*
function bind_to_template( $template, $replacements) 
{
    return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) 
    {
        return $replacements[$matches[1]];
    }, $template);
}
*/

function bind_to_template($template, $replacements){
    foreach ($replacements as $key => $value){
        if ("$key" === "image_url" And "$value" === "null" ){
            $value = "resources/images/default.jpg";
        }

        $template = str_replace("{{{$key}}}", "$value",$template);
    }

    return $template;
}

function fill_template($template, $templateData){
    $result = "";

    if ($templateData["count"] > 0){
        foreach ($templateData as $key => $values){
            if (preg_match('/^project\d+/',$key)){
                $result = $result . bind_to_template($template, $values);
            }
        }
    }else{
        $result = "<h2>Sorry, nothing was found.</h2>";
    }

    return $result;
}

function fill_myproject_template($template, $templateData){
    $result = "";
        foreach ($templateData as $key => $values){
            if (preg_match('/^project\d+/',$key)){
                $result = $result . bind_to_template($template, $values);    
			
        }
    }

    return $result;
}

function fill_viewallproject_template($template, $templateData){
    $result = "";
    foreach ($templateData as $key => $values){
        if (preg_match('/^project\d+/',$key)){
            $result = $result . bind_to_template($template, $values);
        }
    }

    return $result;
}

function GetFilledTemplate($pathToTemplate, $templateData){
    FillLocalImages();
    $template = file_get_contents($pathToTemplate);
    $result = fill_template($template, $templateData);
    return $result;
}


function GetFilledTemplateMyProjectCreator ($pathToTemplate,$templateData){
	    FillLocalImages();
    $template = file_get_contents($pathToTemplate);
    $result = fill_myproject_template($template, $templateData['projects']['creator']);
    return $result;

	
}
function GetFilledTemplateMyProjectModerator ($pathToTemplate,$templateData){
	    FillLocalImages();
    $template = file_get_contents($pathToTemplate);
    $result = fill_myproject_template($template, $templateData['projects']['moderator']);
	$result = $result;
    return $result;

	
}
function GetFilledTemplateMyProjectParticipant ($pathToTemplate,$templateData){
	    FillLocalImages();
    $template = file_get_contents($pathToTemplate);
    $result = fill_myproject_template($template, $templateData['projects']['participant']);
    return $result;

	
}
function GetFilledTemplateViewAllProject ($pathToTemplate,$templateData){
    FillLocalImages();
    $template = file_get_contents($pathToTemplate);
    $result = fill_viewallproject_template($template, $templateData['projects']);
    return $result;

	
}

function FillLocalImages(){
    if (!@array_key_exists($_SESSION["local-images"])){
        $local_images = scandir("resources/images");
        $local_images = array_diff($local_images, array('.','..'));
        $local_images_count = count($local_images);

        $_SESSION["local-images"] = array("names" => $local_images,
                                            "count" => $local_images_count);
    }
}

// SINGLE VIEW TEMPLATES - WILL EVENTUALLY MERGE WITH OTHER FUNCTIONS

function fill_template_single_nested( $template, $replacements) 
{
    return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) 
    {
        if(!is_array($replacements[$matches[1]])) {
            return $replacements[$matches[1]];    
        }
        else{
            return "{{".$matches[1]."}}";
        }
    }, $template);
}


function fill_template_single( $template, $replacements) 
{
    return preg_replace_callback('/{{(.+?)}}/', function($matches) use ($replacements) 
    {
        if(array_key_exists($matches[1], $replacements) && !is_array($replacements[$matches[1]])) {
            if ( $matches[1] == "image_url" And $replacements[$matches[1]] == "null" ){
                return "resources/images/default.jpg";
            }
            return $replacements[$matches[1]];    
        }
        else {
            if($matches[1] == "project_tags") {
                $tags = "";
                foreach ($replacements[$matches[1]] as $tag) {
                    $tags = $tags . "<a class='tag' href='index.php?content=simple-search&query=" . $tag . "'>" . "<span style='font-size: .8em'><i class='fas fa-tag'></i></span> " . $tag . "</a>";
                }
                return $tags;
            }
            else if($matches[1] == "project_creator") {
                $creator = "<ul>";
                foreach ($replacements["project_members"]["creator"] as $mod) {
                    $creator = $creator . "<li><a href='mailto:" . $mod["email"] . "'>" . $mod["display-name"] . "</a>";
                }
                return $creator . "</ul>";
            }
            else if($matches[1] == "project_moderators") {
                $moderators = "<ul>";
                foreach ($replacements["project_members"]["moderators"] as $mod) {
                    $moderators = $moderators . "<li><a href='mailto:" . $mod["email"] . "'>" . $mod["display-name"] . "</a>";
                }
                return $moderators . "</ul>";
            }
            else if($matches[1] == "project_members") {
                $participants = "<ul>";
                foreach ($replacements["project_members"]["participants"] as $part) {
                    $participants = $participants . "<li><a href='mailto:" . $part["email"] . "'>" . $part["display-name"] . "</a>";
                }
                return $participants . "</ul>";
            }
            else if($matches[1] == "project_collabs") {
                $collabs = "<ul>";
                foreach ($replacements[$matches[1]] as $collab) {
                    $collabs = $collabs . "<li><a href='" . $collab["collab-uri"] . "'>" . $collab["collab-name"] . "</a></li>";
                }
                return $collabs . "</ul>";
                //return implode(', ', array_column($replacements[$matches[1]]["participants"], 'display-name'));
            }
            else if($matches[1] == "project_artifacts") {
                $artifacts = "";
                foreach ($replacements[$matches[1]] as $artifact) {
                    $artifacts = $artifacts . "<a class='tag' href='" . $artifact["artifact-location"] . "' target='_blank'>" . "<span style='font-size: .8em'><i class=\"fas fa-file\"></i></span> " . $artifact["artifact-name"] . "</a>";
                }
                return $artifacts;
            }
                
            else return "{{".$matches[1]."}}";
        }
    }, $template);
}

function GetFilledTemplateSingle($pathToTemplate, $templateData){
    $template = file_get_contents($pathToTemplate);
    $result = fill_template_single($template, $templateData);
    return $result;
}

?>