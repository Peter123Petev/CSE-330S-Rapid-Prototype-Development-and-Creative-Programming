<?php
	require 'database.php';

	session_start();
	ini_set("session.cookie_httponly", 1);

	$json_str = file_get_contents('php://input');
	$json_obj = json_decode($json_str, true);

	$username = $json_obj['username'];
	$password = $json_obj['password'];

	$stmt = $mysqli->prepare("select * from users;");
	$stmt->execute();
	$stmt->bind_result($user_id, $username_iteration, $hashpw_iteration);
	$success = false;
	while($stmt->fetch()){
		if(trim($username_iteration) == trim($username) && password_verify($password, $hashpw_iteration)){
			$_SESSION['username'] = $username;
			$_SESSION['logged_in'] = true;
			$_SESSION['user_id'] = $user_id;
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32)); 
			$success = true;
		}
	}
	
	if($success){
		echo json_encode(array(
			"success" => true,
			"username" => "$_SESSION[username]",
			"id" => "$_SESSION[user_id]",
			"token" => "$_SESSION[token]"
		));
		exit;
	}else{
		echo json_encode(array( "success" => false));
		exit;
	}
?>