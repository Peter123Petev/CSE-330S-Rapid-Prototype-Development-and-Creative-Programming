<!DOCTYPE html>
<html lang="en">
<head>
	<title>Home</title>
</head>
	<body>
		<?php
			//Start the session, set logged variable to false
			session_start();
			$_SESSION['logged_in'] = false;

			//automatically redirect to login page
			header("Location: boxlogin.php");
			exit;
		?>
	</body>
</html>