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

			//Check for logged in and make sure the comment isn't blank
			if($logged_in && !empty(htmlentities($_POST['comment']))){
				$stmt = $mysqli->prepare("select comment_id, author_id from comments;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($comment_id, $author_id);

				while($stmt->fetch()){
					if($comment_id == $_POST['comment_id'] && $author_id == $_SESSION['user_id']){
						$editable = true;
					}
				}

				//Update comment if it can be edited
				if($editable && hash_equals($_SESSION['token'], $_POST['token'])){
					$stmt = $mysqli->prepare("update comments set comment=? where comment_id=?;");
					$stmt->bind_param('si', $_POST['comment'], $_POST['comment_id']);
					$stmt->execute();
				}	
			}
			header("Location: account.php");
			exit;
		?>
	</body>
</html>