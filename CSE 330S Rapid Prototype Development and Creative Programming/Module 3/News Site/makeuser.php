<!DOCTYPE html>
<html lang="en">
<head>
	<title>The Scoop</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<?php
		require 'database.php';
		$new_user = $_POST['newuser'];
		$new_pass = $_POST['newpass'];
		session_start();
		$_SESSION['user_is_new'] = true;

		$stmt = $mysqli->prepare("select user from accounts;");
		
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->execute();

		$stmt->bind_result($current_user);

		while($stmt->fetch()){
			if(trim($current_user) == trim(htmlentities($new_user))){
				$_SESSION['user_is_new'] = false;
			}
		}

		echo "
				<nav class=\"navbar sticky-top navbar-expand-lg navbar-light bg-light\">
  					<a class=\"navbar-brand\" href=\"home.php\">Home</a>
					<div class=\"collapse navbar-collapse\" id=\"navbarNavAltMarkup\">
						<div class=\"navbar-nav\">";
							if($_SESSION['logged_in']){			
								echo"
									<a class=\"nav-item nav-link\" href=\"account.php\">Account</a>
									<a class=\"nav-item nav-link\" href=\"logout.php\">Logout</a>
									<a class=\"nav-item nav-link disabled\">Logged in as ".$_SESSION['user']."</a>
								";
							}else{
								echo"
									<a class=\"nav-item nav-link\" href=\"login.php\">Login</a>
									<a class=\"nav-item nav-link\" href=\"register.php\">Register</a>
								";
							}     					
    						echo "</div>
					</div>
					<form class=\"form-inline\" action=\"search.php\" method=\"POST\">
  						<input type=\"text\" name=\"filter\" id=\"filter\" placeholder=\"Search Site\">
  						<button type=\"submit\">Submit</button>
					</form>
				</nav>
			";

		//Create user if fields aren't blank and the user isn't already taken
		if(!empty(htmlentities($_POST['newuser'])) && !empty(htmlentities($_POST['newpass'])) && $_SESSION['user_is_new'] && hash_equals($_SESSION['token'], $_POST['token'])){
			$safe_new_user = $mysqli->real_escape_string($new_user);
			$stmt = $mysqli->prepare("insert into accounts (`user`,`hash_pass`) values ('".$safe_new_user."','".password_hash(htmlentities($new_pass), PASSWORD_BCRYPT)."');");
			$stmt->execute();
			echo "
				<div class=\"alert alert-success\" role=\"alert\">
					Registration Successful! Welcome to the site, ".htmlentities($new_user)."!
				</div>
			";
		}else{
			echo "
				<div class=\"alert alert-danger\" role=\"alert\">
					Registration Failed. Username taken.
				</div>
			";
		}	
	?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>