<?php
include('jamcomm.utils.php');

/*
Summary:
Send a request to the backend server and do not
wait for a response

Parameters:
$resquestArray
	An associative array that contains data to
	be sent to the backend server

Remarks:
This functions should be used when you need
to send database but a response is not
nessecary. Any exceptions raised are
ignored. Use of this function should
be limited to as few situations as possible
*/
function SendBackendRequest($requestArray){
	DoSendRequest($requestArray, FALSE);
}


/*
Summary:
Send a request to the backend server and wait
for a response

Parameters:
$resquestArray
	An associative array that contains data to
	be sent to the backend server

Returns:
An associative array containing data that
is the response from the backend server

Remarks:
This function should be preferred over
SendBackendRequest(). Pieces of the data
returned include status of response (e.g.
whether and error occurred or not results
returned) in addition to request specific
response information. This function will
block until a server response is received.
*/
function SendBackendRequestAwait($requestArray){
	$result = DoSendRequest($requestArray, TRUE);
	return $result;
}

?>