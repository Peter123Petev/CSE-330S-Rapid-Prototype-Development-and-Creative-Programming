<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
	<body>
		<?php
			require 'database.php';
			session_start();
			if(empty(htmlentities($_GET['like'])) || empty(htmlentities($_GET['story']))){
				header("Location: home.php");
				exit;
			}
			$logged_in = $_SESSION['logged_in'];
			$user_id = $_SESSION['user_id'];
			$set_like = $_GET['like'] == 'true' ? true : false;
			$story_id = $_GET['story'];

			$safe_story_id = $mysqli->real_escape_string($story_id);
			$safe_user_id = $mysqli->real_escape_string($user_id);

			//Make sure user is logged in
			if($logged_in){
				echo $set_like;
				echo $story_id;
				//toggle the like based on what it already is
				if($set_like){
					echo "Running like";
					$stmt = $mysqli->prepare("insert into likes (`story_id`,`user_id`) values (".$safe_story_id.",'".$safe_user_id."');");
					if(!$stmt){
						printf("Query Prep Failed: %s\n", $mysqli->error);
						exit;
					}

					$stmt->execute();
				}else{
					echo "Running unlike";
					$stmt = $mysqli->prepare("delete from likes where story_id=".$safe_story_id." and user_id=".$safe_user_id.";");
					if(!$stmt){
						printf("Query Prep Failed: %s\n", $mysqli->error);
						exit;
					}

					$stmt->execute();
				}
			}

			header("Location: home.php");
			exit;
		?>
	</body>
</html>