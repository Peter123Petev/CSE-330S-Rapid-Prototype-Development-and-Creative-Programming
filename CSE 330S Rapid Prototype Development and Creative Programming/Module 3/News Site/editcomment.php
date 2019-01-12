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
			session_start();
			$logged_in = $_SESSION['logged_in'];
			$user = $_SESSION['user'];
			$editable = false;
			$old_comment = "";

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

			//make sure user is logged in
			if($logged_in){
				$stmt = $mysqli->prepare("select comment_id, author_id, comment from comments;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($comment_id, $author_id, $comment_body);

				//update comment update
				while($stmt->fetch()){
					if($comment_id == $_GET['id'] && $author_id == $_SESSION['user_id']){
						$editable = true;
						$old_comment = $comment_body;
					}
				}				
			}

			//comment update form
			if($editable){
				echo "
					<div class=\"card w-50 mx-auto\">
						<div class=\"card-body\">
							<form action=\"commentupdater.php\" method=\"POST\">
								<input type=\"hidden\" name=\"token\" value=\"".$_SESSION['token']."\" />
								<input type=\"hidden\" name=\"comment_id\" id=\"comment_id\" value=\"".htmlentities($_GET['id'])."\">
								<div class=\"form-group\">
									<label for=\"comment\">Comment</label>
    									<input type=\"text\" class=\"form-control-file\" name=\"comment\" id=\"comment\" value=\"".$old_comment."\">
								</div>
								<button type=\"submit\" class=\"btn btn-light\">Submit</button>
							</form>
						</div>
					</div>
				";
			}else{
				header("Location: account.php");
				exit;
			}

			echo "	<br />
				<div class=\"row\">
				<div class=\"col-sm-12\">
				<div class=\"text-center\">
				<a class=\"btn btn-primary\" href=\"account.php\" role=\"button\">Cancel</a>
				</div>
				</div>
				</div>
			";
		?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>