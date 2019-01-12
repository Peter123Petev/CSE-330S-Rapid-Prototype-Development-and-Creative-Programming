<?php
	$mysqli = new mysqli('localhost', 'Mod3', 'Mod3', 'Mod3DB');
	if($mysqli->connect_errno) {
		printf("Connection Failed: %s\n", $mysqli->connect_error);
		exit;
	}
?>