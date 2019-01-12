<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
	<body>
		<?php
			require 'database.php';
			session_start();
			$logged_in = $_SESSION['logged_in'];
			$user = $_SESSION['user'];
			$editable = false;
			$old_title = "";
			$old_body = "";
			$old_link = "";

			//make sure the user is logged in, and that they are the author
			if($logged_in){
				$stmt = $mysqli->prepare("select story_id, author_id, title, body, link from stories;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($story_id, $author_id, $story_title, $story_body, $story_link);

				while($stmt->fetch()){
					if($story_id == $_POST['story_id'] && $author_id == $_SESSION['user_id']){
						$editable = true;
						$old_title = $story_title;
						$old_body = $story_body;
						$old_link = $story_link;
					}
				}				
			}

			//if the story doesn't have empty parts and it can be edited by the user, edit it
			if(!empty(htmlentities($_POST['title'])) && !empty(htmlentities($_POST['body'])) && $editable && hash_equals($_SESSION['token'], $_POST['token'])){
				echo $_POST['title'];
				echo $_POST['body'];
				echo $_POST['link'];
				$safe_title = $mysqli->real_escape_string($_POST['title']);
				$safe_body = $mysqli->real_escape_string($_POST['body']);
				$safe_link = $mysqli->real_escape_string($_POST['link']);
				$safe_story_id = $mysqli->real_escape_string($_POST['story_id']);
				$stmt = $mysqli->prepare("update stories set title='".$safe_title."',body='".$safe_body."',link='".$safe_link."' where story_id=".$safe_story_id.";");
				$stmt->execute();
			}

			header("Location: account.php");
			exit;
		?>
	</body>
</html>