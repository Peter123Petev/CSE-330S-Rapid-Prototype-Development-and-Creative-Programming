<?php
	require 'database.php';
	
	session_start();

	$previous_ua = @$_SESSION['useragent'];
	$current_ua = $_SERVER['HTTP_USER_AGENT'];

	if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
		die("Session hijack detected");
	}else{
		$_SESSION['useragent'] = $current_ua;
	}

	$json_str = file_get_contents('php://input');
	$json_obj = json_decode($json_str, true);

	//Checks if token is valid
	$event_id = $json_obj['event_id'];
	if($json_obj['token'] !== $_SESSION['token']){
		die("Invalid Token.");
	}

	//Sends deletion command to sql, the event_id is already sanitized.
	$command = "delete from events where event_id = ".$event_id.";";
	$stmt = $mysqli->prepare($command);
	$stmt->execute();
	echo json_encode(array("command" => $command));
	exit;	
?>