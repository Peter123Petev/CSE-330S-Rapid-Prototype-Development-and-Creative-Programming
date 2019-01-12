<?php
// Start Session
session_start();
// Initialize variable
$user = "";

// Verifies file
$file_to_load = $_GET['file'];

if( !preg_match('/^[\w_\.\-]+$/', $file_to_load) ){
	//echo "Invalid filename";
	exit;
}
if( !preg_match('/^[\w_\-]+$/', $_SESSION['user']) ){
	//echo "Invalid username";
	exit;
}

// Creates path and mime, then displays file
$full_path = sprintf("/etc/330class/330Box/boxusers/%s/%s", $_SESSION['user'], $file_to_load);
$full_path = "/etc/330class/330Box/boxusers/".$_SESSION['user']."/".$file_to_load;
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->file($full_path);
	
header("Content-Type: ".$mime);
readfile($full_path);
?>