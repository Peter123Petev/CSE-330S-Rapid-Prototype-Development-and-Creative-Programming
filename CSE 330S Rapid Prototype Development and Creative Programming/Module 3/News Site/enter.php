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
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		if(empty(htmlentities($_POST['user'])) || empty(htmlentities($_POST['pass']))){
			header("Location: login.php");
			exit;
		}
		session_start();

		$stmt = $mysqli->prepare("select * from accounts;");
		
		if(!$stmt){
			printf("Query Prep Failed: %s\n", $mysqli->error);
			exit;
		}

		$stmt->execute();

		$stmt->bind_result($user_id, $current_user, $current_hashpw);

		//Check to see if user exists
		$success = false;
		while($stmt->fetch()){
			if(trim(htmlentities($current_user)) == trim(htmlentities($user)) && password_verify($pass, $current_hashpw)){
				$_SESSION['user'] = $user;
				$_SESSION['logged_in'] = true;
				$_SESSION['user_id'] = $user_id;
				$success = true;
				break;
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
		
		//Login if successful
		if($success){
			echo "
				<div class=\"alert alert-success\" role=\"alert\">
					Login Successful! Welcome ".htmlentities($user)."!
				</div>
			";
		}else{
			echo "
				<div class=\"alert alert-danger\" role=\"alert\">
					Login Failed. Invalid Credentials.
				</div>
			";
		}
	?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>