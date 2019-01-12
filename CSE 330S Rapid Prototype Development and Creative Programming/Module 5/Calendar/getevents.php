<?php
	require 'database.php';

	$json_str = file_get_contents('php://input');
	$json_obj = json_decode($json_str, true);

	$userid = $json_obj['userid'];

	$events = array();

	//Loads all events with this user's id from the sql
	$stmt = $mysqli->prepare("select * from events where user_id=".$userid.";");
	$stmt->execute();
	$stmt->bind_result($event_id, $user_id, $title, $tag, $description, $hourstart, $minutestart, $daystart, $monthstart, $yearstart, $hourend, $minuteend, $dayend, $monthend, $yearend);
	while($stmt->fetch()){
		$event = array(
			"event_id" => htmlentities($event_id),
			"title" => htmlentities($title),
			"tag" => htmlentities($tag),
			"description" => htmlentities($description),
			"hourstart" => htmlentities($hourstart),
			"minutestart" => htmlentities($minutestart),
			"daystart" => htmlentities($daystart),
			"monthstart" => htmlentities($monthstart),
			"yearstart" => htmlentities($yearstart),
			"hourend" => htmlentities($hourend),
			"minuteend" => htmlentities($minuteend),
			"dayend" => htmlentities($dayend),
			"monthend" => htmlentities($monthend),
			"yearend" => htmlentities($yearend)
		);
		$events[] = $event;
	}
	echo json_encode($events);
	exit;
?>