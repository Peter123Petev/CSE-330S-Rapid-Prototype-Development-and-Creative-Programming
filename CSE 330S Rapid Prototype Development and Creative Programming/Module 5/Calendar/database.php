<?php
	//Sets up database authentication
	$mysqli = new mysqli('localhost', 'Mod5', 'Mod5', 'calendar');
	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
?>