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

			//make sure user is logged in
			if($logged_in){
				$stmt = $mysqli->prepare("select comment_id, author_id from comments;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($comment_id, $author_id);

				while($stmt->fetch()){
					if($comment_id == $_GET['id'] && $author_id == $_SESSION['user_id']){
						$deletable = true;
					}
				}

				//check if the comment should be deletable
				if($deletable){
					$safe_id = $mysqli->real_escape_string($_GET['id']);
					$stmt = $mysqli->prepare("delete from comments where comment_id=".$safe_id.";");
					$stmt->execute();
				}

				header("Location: account.php");
				exit;
			}
		?>
	</body>
</html>