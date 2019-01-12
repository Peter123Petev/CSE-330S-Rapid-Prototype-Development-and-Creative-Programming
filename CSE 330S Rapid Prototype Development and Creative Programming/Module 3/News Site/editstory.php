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
			$old_title = "";
			$old_body = "";
			$old_link = "";

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

			//See if the user is able to edit the story
			if($logged_in){
				$stmt = $mysqli->prepare("select story_id, author_id, title, body, link from stories;");

				if(!$stmt){
					printf("Query Prep Failed: %s\n", $mysqli->error);
					exit;
				}

				$stmt->execute();

				$stmt->bind_result($story_id, $author_id, $story_title, $story_body, $story_link);

				while($stmt->fetch()){
					if($story_id == $_GET['id'] && $author_id == $_SESSION['user_id']){
						$editable = true;
						$old_title = $story_title;
						$old_body = $story_body;
						$old_link = $story_link;
					}
				}				
			}

			//Show edit form if possible for user to edit
			if($editable){
				echo "
					<div class=\"card w-25 mx-auto\">
  						<div class=\"card-body\">
							<h3 class=\"text-center\">Edit Story</h3>
							<form action=\"storyupdater.php\" method=\"POST\">
								<input type=\"hidden\" name=\"token\" value=\"".$_SESSION['token']."\" />
								<input type=\"hidden\" name=\"story_id\" id=\"story_id\" value=\"".$_GET['id']."\">
								<div class=\"form-group\">
									<label for=\"title\">Title</label>
    									<input type=\"text\" name=\"title\" id=\"title\" class=\"form-control\" value=\"".$old_title."\">
								</div>
								<div class=\"form-group\">
									<label for=\"link\">Link</label>
    									<input type=\"text\" name=\"link\" id=\"link\" class=\"form-control\" value=\"".$old_link."\">
								</div>
								<div class=\"form-group\">
									<label for=\"body\">Body</label>
    									<input type=\"text\" name=\"body\" id=\"body\" class=\"form-control\" value=\"".$old_body."\">
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