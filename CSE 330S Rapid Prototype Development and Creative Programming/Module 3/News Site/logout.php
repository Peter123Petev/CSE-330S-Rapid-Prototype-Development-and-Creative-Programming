<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
</head>
	<body>
		<?php
			//Destroys session and restarts
			session_start();
			session_destroy();
			header("Location: start.php");
			exit;
		?>
	</body>
</html>