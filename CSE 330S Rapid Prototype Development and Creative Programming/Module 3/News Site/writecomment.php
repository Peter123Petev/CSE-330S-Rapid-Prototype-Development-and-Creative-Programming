<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
<body>
	<?php
		require 'database.php';
		session_start();

		$stmt = $mysqli->prepare("insert into comments (`story_id`,`author_id`,`comment`) values (?,?,?);");
		
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		//$safe_story_id = $mysqli->real_escape_string($_POST['story_id']);
		//$safe_user_id = $mysqli->real_escape_string($_SESSION['user_id']);
		//$safe_comment = $mysqli->real_escape_string($_POST['comment']);

		$safe_story_id = $_POST['story_id'];
		$safe_user_id = $_SESSION['user_id'];
		$safe_comment = $_POST['comment'];

		$stmt->bind_param('iis', htmlentities($safe_story_id), htmlentities($safe_user_id), htmlentities($safe_comment));

		//If comment has no blank fields, and access token is correct, write the comment
		if(!empty(htmlentities($_POST['story_id'])) && !empty(htmlentities($_SESSION['user_id'])) && !empty(htmlentities($_POST['comment'])) && hash_equals($_SESSION['token'], $_POST['token'])){
			$stmt->execute();
		}
		
		header("Location: home.php");
		exit;
	?>
</body>
</html>