<!DOCTYPE html>
<html lang="en">
<head>
	<title>Box</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>
	<!––	https://getbootstrap.com/docs/4.1/components/	-->
	<!––	used the component template for cards		-->
	<div class="card mx-auto" style="width: 18rem;">
		<div class="card-body">
			<?php
				// Create a new user from POST
				$new_user = $_POST['newuser'];
	
				// Start a session, make user variables
				session_start();
				$_SESSION['user_is_new'] = true;
				$_SESSION['user'] = $new_user;

				// Scan for current users
				$h = fopen(sprintf("/etc/330class/330Box/users.txt"), "r");
				$linenum = 1;
				while( !feof($h) ){
					$current_test = fgets($h);
					if(trim($current_test) == trim($new_user)){
						$_SESSION['user_is_new'] = false;
					}
				}
				fclose($h);

				// Create a new user if they are unique
				if($_SESSION['user_is_new']){
					$full_path = sprintf("/etc/330class/330Box/boxusers/".$new_user);
					if (!is_dir($full_path)) {
    						mkdir($full_path, 0777, true);
					}

					$appender = fopen(sprintf("/etc/330class/330Box/users.txt"), "a");
					fwrite($appender, "\n".$new_user);
					fclose($appender);

					echo "
					<h5 class=\"card-title\">Registration Successful!</h5>
    					<p class=\"card-text\">\"".$new_user."\" has been created.</p>
    					<a href=\"boxhome.php\" class=\"card-link\">Log In</a>
					";
				}else{
					echo "
    					<h5 class=\"card-title\">Registration Unsuccessful.</h5>
    					<p class=\"card-text\">That username is taken.</p>
    					<a href=\"boxregister.php\" class=\"card-link\">Try Again</a>
    					<a href=\"boxhome.php\" class=\"card-link\">Cancel</a>
					";
				}
			?>
		</div>
	</div>
	<!––	End Comment					-->
	
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>