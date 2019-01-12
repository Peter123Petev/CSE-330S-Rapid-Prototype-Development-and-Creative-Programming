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

	//Sanitizes new inputs
	$username = $mysqli->real_escape_string($json_obj['username']);
	$password = $mysqli->real_escape_string($json_obj['password']);

	//Checks if username is taken and new credentials are valid
	$stmt = $mysqli->prepare("select * from users;");
	$stmt->execute();
	$stmt->bind_result($user_id, $username_iteration, $hashpw_iteration);
	$success = true;
	while($stmt->fetch()){
		if(trim($username_iteration) == trim($username)){ 
			$success = false;
		}
	}
	if(strlen($username) <= 1 || strlen($password) <= 1){
		$success = false;
	}
	
	if($success){
		$stmt = $mysqli->prepare("insert into users (`user`,`pass`) values ('".$username."','".password_hash($password, PASSWORD_BCRYPT)."');");
		$stmt->execute();
		echo json_encode(array( "success" => true));
		exit;
	}else{
		echo json_encode(array( "success" => false));
		exit;
	}
?>