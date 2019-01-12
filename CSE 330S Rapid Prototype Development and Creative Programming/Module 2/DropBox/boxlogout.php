<!DOCTYPE html>
<html lang="en">
<head>
	<title>Box</title>
</head>
<body>
	<p><?php
		//Start the session
		session_start();

		//Clear the user name, log out
		$_SESSION['user'] = "_____";
		$_SESSION['logged_in'] = true;

		//Destroy session to complete logout
		session_destroy();

		//Redirect
		header("Location: boxhome.php");
		exit;
	?></p>
</body>
</html>