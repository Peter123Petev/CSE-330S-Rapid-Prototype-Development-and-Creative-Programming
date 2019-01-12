<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
<body>
	<?php
		require 'database.php';
		session_start();

		$stmt = $mysqli->prepare("insert into stories (`author_id`,`title`,`body`,`link`) values (?,?,?,?);");
		
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		//$safe_user_id = $mysqli->real_escape_string($_SESSION['user_id']);
		//$safe_title = $mysqli->real_escape_string($_POST['title']);
		//$safe_body = $mysqli->real_escape_string($_POST['body']);
		//$safe_link = $mysqli->real_escape_string($_POST['link']);

		$safe_user_id = $_SESSION['user_id'];
		$safe_title = $_POST['title'];
		$safe_body = $_POST['body'];
		$safe_link = $_POST['link'];

		$stmt->bind_param('isss', $safe_user_id, $safe_title, $safe_body, $safe_link);

		//Make sure the story doesn't have empty required fields, and check token to post.
		if(!empty(htmlentities($_POST['title'])) && !empty(htmlentities($_POST['body'])) && hash_equals($_SESSION['token'], $_POST['token'])){
			$stmt->execute();
		}
		
		header("Location: account.php");
		exit;
	?>
</body>
</html>