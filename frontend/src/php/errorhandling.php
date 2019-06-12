<?php

function CreateDefaultInvalidResponseArray($whyIsInvalid){
    $e = new \Exception;
    $result = array("exception-details" => array(
                    "message" => "Response is invalid. $whyIsInvalid.",
                    "number" => 1,
                    "stack-trace" => $e->getTraceAsString()
        )
    );
}


function RedirectIfResponseIsBad($response){
    if (!@array_key_exists("exception-details", $response)){
        $reponse = CreateDefaultInvalidResponseArray("Response missing 'exception-details'");
    }
    
    print_r($response);
    $_SESSION["whoopsie"] = $response["exception-details"];

    header("Location: whoopsie.php");
}

function RedirectIfInvalidContentType($theContentType, $validContentTypes){
    if (!@in_array($theContentType, $validContentTypes)){
        header("Location: index.php?content=featured");
    }
}





?>