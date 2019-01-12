<?php
	require 'database.php';

	$json_str = file_get_contents('php://input');
	$json_obj = json_decode($json_str, true);

	$userid = $json_obj['userid'];

	$events = array();

	$sharers = array();

	//Finds all users who have shared calendars with current user
	$stmt = $mysqli->prepare("select * from sharing where sharee_user_id=".$userid.";");
	$stmt->execute();
	$stmt->bind_result($share_id, $sharer_id, $sharee_id);
	while($stmt->fetch()){
		$sharers[] = $sharer_id;
	}

	$sharers = array_unique($sharers);

	//Adds events from every sharer, with their name attached so they know who's calendar it's from
	foreach($sharers as $current_sharer){
		$stmt = $mysqli->prepare("select * from events join users on (events.user_id=users.user_id) where events.user_id=".$current_sharer.";");
		$stmt->execute();
		$stmt->bind_result($event_id, $user_id, $title, $tag, $description, $hourstart, $minutestart, $daystart, $monthstart, $yearstart, $hourend, $minuteend, $dayend, $monthend, $yearend, $userid2, $eventholder, $hashpw);
		while($stmt->fetch()){
			$event = array(
				"event_id" => $event_id,
				"title" => "(".$eventholder.") ".$title,
				"tag" => $tag,
				"description" => $description,
				"hourstart" => $hourstart,
				"minutestart" => $minutestart,
				"daystart" => $daystart,
				"monthstart" => $monthstart,
				"yearstart" => $yearstart,
				"hourend" => $hourend,
				"minuteend" => $minuteend,
				"dayend" => $dayend,
				"monthend" => $monthend,
				"yearend" => $yearend
			);
			$events[] = $event;
		}
	}
	
	echo json_encode($events);
	exit;
?>