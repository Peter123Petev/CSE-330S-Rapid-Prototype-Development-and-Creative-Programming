<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
	<body>
		<?php
			//Start the session over
			session_start();
			$_SESSION['logged_in'] = false;
			$_SESSION['user'] = "_____________";
			$_SESSION['user_id'] = 0;

			//Create the token
			$_SESSION['token'] = bin2hex(openssl_random_pseudo_bytes(32));
			header("Location: home.php");
			exit;
		?>
	</body>
</html>