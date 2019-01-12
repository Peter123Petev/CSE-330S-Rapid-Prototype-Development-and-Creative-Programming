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
	if($json_obj['token'] !== $_SESSION['token']){
		die("Invalid Token.");
	}

	//Sanitizes all variables that are not already sanititzed numbers
	$userid = $json_obj['userid'];
	$title = $mysqli->real_escape_string($json_obj['title']);
	$description = $mysqli->real_escape_string($json_obj['description']);
	$tag = $mysqli->real_escape_string($json_obj['tag']);
	$others = $json_obj['others'];
	$startyear = $json_obj['startyear'];
	$startmonth = $json_obj['startmonth'];
	$startday = $json_obj['startday'];
	$endyear = $json_obj['endyear'];
	$endmonth = $json_obj['endmonth'];
	$endday = $json_obj['endday'];
	$starthour = $json_obj['starthour'];
	$startminute = $json_obj['startminute'];
	$endhour = $json_obj['endhour'];
	$endminute = $json_obj['endminute'];

	//Doesn't allow events with blank fields.
	if(strlen($title) < 1|| strlen($description) < 1){
		die("Event contains blank fields.");
	}

	//Inserts event if valid
	$command = "insert into events (`user_id`,`title`,`tag`,`description`,`hourstart`,`minutestart`,`daystart`,`monthstart`,`yearstart`,`hourend`,`minuteend`,`dayend`,`monthend`,`yearend`) values ('".$userid."', '".$title."', '".$tag."', '".$description."',".$starthour.",".$startminute.",".$startday.",".$startmonth.",".$startyear.",".$endhour.",".$endminute.",".$endday.",".$endmonth.",".$endyear.");";
	$stmt = $mysqli->prepare($command);
	$stmt->execute();

	//Also adds event to all other users in group
	$stmt3 = $mysqli->prepare("select * from users;");
	$stmt3->execute();
	$stmt3->bind_result($otheruserid, $username_iteration, $hashpw_iteration);
	$to_add = array();
	while($stmt3->fetch()){
		if(in_array($username_iteration, $others)){
			$command2 = "insert into events (`user_id`,`title`,`tag`,`description`,`hourstart`,`minutestart`,`daystart`,`monthstart`,`yearstart`,`hourend`,`minuteend`,`dayend`,`monthend`,`yearend`) values ('".$otheruserid."', '".$title."', '".$tag."', '".$description."',".$starthour.",".$startminute.",".$startday.",".$startmonth.",".$startyear.",".$endhour.",".$endminute.",".$endday.",".$endmonth.",".$endyear.");";
			$to_add[] = $command2;			
		}
	}
	foreach($to_add as $commandtodo){
		$stmt2 = $mysqli->prepare($commandtodo);
		$stmt2->execute();
	}

	exit;	
?>