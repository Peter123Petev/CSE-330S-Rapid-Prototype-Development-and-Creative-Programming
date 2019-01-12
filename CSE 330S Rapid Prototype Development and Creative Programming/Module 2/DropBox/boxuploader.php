<!DOCTYPE html>
<html lang="en">
<head>
	<title>Box</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<p><?php
	// Start Session
	session_start();
	// Initialize Variable
	$user = "";
	
	// Login checker
	if(isset($_SESSION['logged_in'])){
		if($_SESSION['logged_in']){
			if(isset($_SESSION['user'])){
				$user = $_SESSION['user'];
			}else{
				header("Location: boxlogin.php");
				exit;
			}
		}else{
			header("Location: boxlogin.php");
			exit;
		}
	}else{
		header("Location: boxlogin.php");
		exit;
	}
	?></p>
	<?php

		// Get the filename and make sure it is valid
		$filename = basename($_FILES['uploadedfile']['name']);
		if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
			echo "<div class=\"alert alert-danger\" role=\"alert\">
  				Invalid filename!
			</div>";
			header("Location: boxfileview.php");
			exit;
		}

		// Get the username and make sure it is valid
		$username = $_SESSION['user'];
		if( !preg_match('/^[\w_\-]+$/', $username) ){
			echo "<div class=\"alert alert-danger\" role=\"alert\">
  				Invalid username!
			</div>";
			header("Location: boxfileview.php");
			exit;
		}

		$full_path = sprintf("/etc/330class/330Box/boxusers/%s/%s", $username, $filename);

		if( move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $full_path) ){
			header("Location: boxfileview.php");
			exit;
		}else{
			header("Location: boxfileview.php");
			exit;
		}
	?>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>