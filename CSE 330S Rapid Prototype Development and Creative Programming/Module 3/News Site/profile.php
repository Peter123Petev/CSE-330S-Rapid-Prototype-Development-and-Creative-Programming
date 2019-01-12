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
			$view_user = $_GET['viewuser'];

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

			echo "<h1 class=\"text-center\">".htmlentities($view_user)."'s Profile</h1>";

			//Create an accordion which displays all of the users stories, comments, likes
			$stmt = $mysqli->prepare("select accounts.user_id, story_id, title, body from stories join accounts on (stories.author_id=accounts.user_id) where accounts.user = ?;");
			$safe_view_user = $mysqli->real_escape_string($view_user);
			$stmt->bind_param('s', $safe_view_user);
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_author_id,$story_id,$story_title,$story_body);

			echo "
				<div class=\"accordion\" id=\"accordionDisplay\">
  					<div class=\"card\">
    						<div class=\"card-header\" id=\"headingOne\">
      							<h5 class=\"mb-0\">
        							<button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseOne\" aria-expanded=\"true\" aria-controls=\"collapseOne\">
									".htmlentities($view_user)."'s Stories
								</button>
							</h5>
						</div>
						<div id=\"collapseOne\" class=\"collapse\" aria-labelledby=\"headingOne\" data-parent=\"#accordionDisplay\">";			

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> ".htmlentities($view_user)." posted ".htmlentities($story_title)."</h5>
							<p class=\"card-text\">".htmlentities($story_body)."</p>
							<a href=\"storyview?story_id=".htmlentities($story_id)."\" class=\"btn btn-light\">Visit</a>
  						</div>
					</div>
				";
			}
							echo "
						</div>
					</div>
				</div>
			";


			$stmt = $mysqli->prepare("select accounts.user_id, stories.story_id, stories.title, comment, comment_id from comments join accounts on (comments.author_id=accounts.user_id) join stories on (comments.story_id=stories.story_id) where accounts.user = ?;");
			$stmt->bind_param('s', $safe_view_user);
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($comment_author_id,$story_id,$story_title, $comment, $comment_id);

			echo "
				<div class=\"accordion\" id=\"accordionDisplay2\">
  					<div class=\"card\">
    						<div class=\"card-header\" id=\"headingTwo\">
      							<h5 class=\"mb-0\">
        							<button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseTwo\" aria-expanded=\"true\" aria-controls=\"collapseTwo\">
									".htmlentities($view_user)."'s Comments
								</button>
							</h5>
						</div>
						<div id=\"collapseTwo\" class=\"collapse\" aria-labelledby=\"headingTwo\" data-parent=\"#accordionDisplay2\">";

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> ".htmlentities($view_user)." commented on ".htmlentities($story_title).":</h5>
    							<p class=\"card-text\">\"".htmlentities($comment)."\"</p>
							<a href=\"storyview?story_id=".htmlentities($story_id)."\" class=\"btn btn-light\">Visit</a>
  						</div>
					</div>
				";
			}
							echo "
						</div>
					</div>
				</div>
			";

			$stmt = $mysqli->prepare("select stories.title, stories.story_id from likes join stories on (likes.story_id=stories.story_id) join accounts on (likes.user_id=accounts.user_id) where accounts.user = ?;");
			$stmt->bind_param('s', $safe_view_user);
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_title,$story_id);

			echo "
				<div class=\"accordion\" id=\"accordionDisplay3\">
  					<div class=\"card\">
    						<div class=\"card-header\" id=\"headingThree\">
      							<h5 class=\"mb-0\">
        							<button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseThree\" aria-expanded=\"true\" aria-controls=\"collapseThree\">
									".htmlentities($view_user)."'s Likes
								</button>
							</h5>
						</div>
						<div id=\"collapseThree\" class=\"collapse\" aria-labelledby=\"headingThree\" data-parent=\"#accordionDisplay3\">";

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> ".htmlentities($view_user)." liked ".htmlentities($story_title)."</h5>
							<a href=\"storyview?story_id=".htmlentities($story_id)."\" class=\"btn btn-light\">Visit</a>
  						</div>
					</div>
				";
			}
							echo "
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