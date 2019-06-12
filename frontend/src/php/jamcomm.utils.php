<?php
include 'php/jamcomm.logging.php';
include 'utils.php';

function DoSendRequest($requestArray, $waitForResponse){
	$result = "";
	
	PrintArrayToLogFile($requestArray, "Request");

	try{
		$requestJson = AssociativeArrayToJson($requestArray);
		$result = DoSendRequestImp($requestJson, $waitForResponse);
		$result = JsonToAssociativeArray($result);

	} catch (Throwable $t){
		$result = JamCommunicationExceptionHandler($t);
	}

	PrintArrayToLogFile($result, "Response");

	return $result;
}

function DoSendRequestImp($jsonRequest, $waitForResponse){
	$host = "localhost";
	$response = "";
	$socket;
	$connection;

	try{
		$port = file_get_contents('sys/jamd.port');

		if (!$socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP)){
			throw new Exception("Socket connection error: " . 
								socket_strerror(socket_last_error()));
		}

		
		
		if ($connection = @socket_connect($socket,$host,$port)){
		
			//stream_set_timeout($socket, 10);
			socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 60, 
															   'usec' => 0));

			try{
				PrintJsonToLogFile($jsonRequest, "Request");

				$send = $jsonRequest.PHP_EOL;
				socket_send($socket,$send,strlen($send),0);

				if ($waitForResponse){
					if (!(false !== ($bytes = socket_recv($socket, $response, 8192, MSG_WAITALL)))){
						throw new Exception("socket_recv() failed: " .
											socket_strerror(socket_last_error()));
					}
				}

			} finally{		
				socket_close($socket);
			}

		}else{
			throw new Exception("Socket connection error: " . 
								socket_strerror(socket_last_error()));
		}

	}catch (Throwable $t){
		$response = AssociativeArrayToJson(FormatFrontEndException($t));
	}

	PrintJsonToLogFile($response, "Response");
	return $response;
}


?>