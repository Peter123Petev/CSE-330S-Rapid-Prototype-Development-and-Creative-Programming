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
			$deletable = false;

			//Make sure user is logged in
			if($logged_in){
				$stmt = $mysqli->prepare("select story_id, author_id from stories;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($story_id, $author_id);

				while($stmt->fetch()){
					if($story_id == $_GET['id'] && $author_id == $_SESSION['user_id']){
						$deletable = true;
					}
				}

				//Make sure the story can be deleted
				if($deletable){
					$safe_story_id = $mysqli->real_escape_string($_GET['id']);
					$stmt = $mysqli->prepare("delete from likes where story_id=".$safe_story_id.";");
					$stmt->execute();
					$stmt = $mysqli->prepare("delete from comments where story_id=".$safe_story_id.";");
					$stmt->execute();
					$stmt = $mysqli->prepare("delete from stories where story_id=".$safe_story_id.";");
					$stmt->execute();
				}

				header("Location: account.php");
				exit;
			}
		?>
	</body>
</html>