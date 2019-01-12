<!DOCTYPE html>
<html lang="en">
<head>
	<title>Box</title>
</head>
<body>
	<?php	
	// Start Session
	session_start();
	// Initialize variable
	$user = "";

	// Validate file to delete
	$file_to_load = $_GET['file'];

	if( !preg_match('/^[\w_\.\-]+$/', $file_to_load) ){
		echo "Invalid filename";
		exit;
	}
	if( !preg_match('/^[\w_\-]+$/', $_SESSION['user']) ){
		echo "Invalid username";
		exit;
	}

	// Build path and delete the file at that path
	$full_path = sprintf("/etc/330class/330Box/boxusers/%s/%s", $_SESSION['user'], $file_to_load);
	$full_path = "/etc/330class/330Box/boxusers/".$_SESSION['user']."/".$file_to_load;
	unlink($full_path);
	header("Location: boxfileview.php");
	exit;
	?>
</body>
</html>