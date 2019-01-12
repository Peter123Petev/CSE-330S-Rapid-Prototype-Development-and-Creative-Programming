<?php
	require 'database.php';

	$previous_ua = @$_SESSION['useragent'];
	$current_ua = $_SERVER['HTTP_USER_AGENT'];

	if(isset($_SESSION['useragent']) && $previous_ua !== $current_ua){
		die("Session hijack detected");
	}else{
		$_SESSION['useragent'] = $current_ua;
	}

	$json_str = file_get_contents('php://input');
	$json_obj = json_decode($json_str, true);

	//Sanitizes users involved in sharing
	$sharerid = $mysqli->real_escape_string($json_obj['sharerid']);
	$shareeuser = $mysqli->real_escape_string($json_obj['shareeuser']);

	//Finds the id of the user to share with
	$stmt = $mysqli->prepare("select user_id from users where user='".$shareeuser."';");
	$stmt->execute();
	$stmt->bind_result($foundshareeuserid);
	$sharee_user_id = -1;
	while($stmt->fetch()){
		$sharee_user_id = $foundshareeuserid;	
	}

	//Sends sharing info to sql
	$stmt = $mysqli->prepare("insert into sharing (`sharer_user_id`,`sharee_user_id`) values (".$sharerid.", ".$sharee_user_id.");");
	$stmt->execute();

	echo json_encode(array('found' => $shareeuser));
	
	exit;
?>