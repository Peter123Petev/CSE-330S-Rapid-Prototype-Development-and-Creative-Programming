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

	//Get username from form
	//Web security
	$user = htmlentities($_POST['username']);

	//Start session and set session variables
	session_start();
	$_SESSION['logged_in'] = false;
	$_SESSION['user'] = $user;

	//Get full path of user list and validate login
	$full_path = sprintf("/etc/330class/330Box/users.txt");
	//Web security
	$h = fopen(htmlentities($full_path), "r");
	$linenum = 1;
	while( !feof($h) ){
		$current_test = fgets($h);
		if(trim($current_test) == trim($user)){
			$_SESSION['logged_in'] = true;
		}
	}
	fclose($h);

	//Validate the log in
	if($_SESSION['logged_in']){
		//Redirect to see files
		header("Location: boxfileview.php");
		exit;
	}else{
		//Quit session and link to restart
		session_destroy();
		echo "
			<!––	https://getbootstrap.com/docs/4.1/components/	-->
			<!––	used the component template for cards		-->
			<div class=\"card mx-auto\" style=\"width: 18rem;\">
  				<div class=\"card-body\">
    					<h5 class=\"card-title\">Login Unsuccessful</h5>
    					<p class=\"card-text\">The username you entered was not found.</p>
    					<a href=\"boxhome.php\" class=\"card-link\">Try Again</a>
    					<a href=\"boxregister.php\" class=\"card-link\">Register</a>
  				</div>
			</div>
			<!––	End citation					-->
		";
	}
	?></p>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>