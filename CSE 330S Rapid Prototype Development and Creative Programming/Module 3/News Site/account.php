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

			echo "<h1 class=\"text-center\">View/Edit My Account's Actions</h1>";

			//Accordion for each section's contents, while loop to fill them up
			echo "
				<div class=\"accordion\" id=\"accordionDisplay\">
  					<div class=\"card\">
    						<div class=\"card-header\" id=\"headingOne\">
      							<h5 class=\"mb-0\">
        							<button class=\"btn btn-link\" type=\"button\" data-toggle=\"collapse\" data-target=\"#collapseOne\" aria-expanded=\"true\" aria-controls=\"collapseOne\">
									My Stories
								</button>
							</h5>
						</div>
						<div id=\"collapseOne\" class=\"collapse\" aria-labelledby=\"headingOne\" data-parent=\"#accordionDisplay\">";			

			$stmt = $mysqli->prepare("select accounts.user_id, story_id, title, body from stories join accounts on (stories.author_id=accounts.user_id) where accounts.user_id = ?;");
			$safe_user_id = $mysqli->real_escape_string($_SESSION['user_id']);
			$stmt->bind_param('i', $safe_user_id);
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_author_id,$story_id,$story_title,$story_body);

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> You posted ".htmlentities($story_title)."</h5>
							<p class=\"card-text\">".htmlentities($story_body)."</p>
							<a href=\"storyview?story_id=".htmlentities($story_id)."\" class=\"btn btn-light\">View</a>
							<a href=\"editstory?id=".htmlentities($story_id)."\" class=\"btn btn-light\">Edit</a>
							<a href=\"deletestory?id=".htmlentities($story_id)."\" class=\"btn btn-light\">Delete</a>
  						</div>
					</div>
				";
			}
							echo "
						</div>
					</div>
				</div>
			";

			$stmt = $mysqli->prepare("select accounts.user_id, stories.story_id, stories.title, comment, comment_id from comments join accounts on (comments.author_id=accounts.user_id) join stories on (comments.story_id=stories.story_id) where accounts.user_id = ?;");
			$safe_user_id = $mysqli->real_escape_string($_SESSION['user_id']);
			$stmt->bind_param('i', $safe_user_id);
		
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
									My Comments
								</button>
							</h5>
						</div>
						<div id=\"collapseTwo\" class=\"collapse\" aria-labelledby=\"headingTwo\" data-parent=\"#accordionDisplay2\">";

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> You commented on ".htmlentities($story_title).":</h5>
    							<p class=\"card-text\">\"".htmlentities($comment)."\"</p>
							<a href=\"storyview?story_id=".htmlentities($story_id)."\" class=\"btn btn-light\">Visit</a>
							<a href=\"editcomment?id=".htmlentities($comment_id)."\" class=\"btn btn-light\">Edit</a>
							<a href=\"deletecomment?id=".htmlentities($comment_id)."\" class=\"btn btn-light\">Delete</a>
  						</div>
					</div>
				";
			}
							echo "
						</div>
					</div>
				</div>
			";

			$stmt = $mysqli->prepare("select stories.title, stories.story_id from likes join stories on (likes.story_id=stories.story_id) where likes.user_id = ?;");
			$safe_user_id = $mysqli->real_escape_string($_SESSION['user_id']);
			$stmt->bind_param('i', $safe_user_id);
		
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
									My Likes
								</button>
							</h5>
						</div>
						<div id=\"collapseThree\" class=\"collapse\" aria-labelledby=\"headingThree\" data-parent=\"#accordionDisplay3\">";			

			while($stmt->fetch()){
				echo "
					<div class=\"card w-25\">
  						<div class=\"card-body\">
    							<h5 class=\"card-title\"> You liked ".htmlentities($story_title)."</h5>
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

			//form for post
			echo "		<br />
					<div class=\"row\">
					<div class=\"col-sm-12\">
					<div class=\"text-center\">
						<a class=\"btn btn-primary\" data-toggle=\"collapse\" href=\"#quickpost\" role=\"button\" aria-expanded=\"false\" aria-controls=\"collapseExample\">Post</a>
					</div>
					</div>
					</div>
					<div class=\"collapse\" id=\"quickpost\">					
					<div class=\"card w-25 mx-auto\">
  						<div class=\"card-body\">
							<h3 class=\"text-center\">Post a New Story</h3>
							<form action=\"poststory.php\" method=\"POST\">
								<input type=\"hidden\" name=\"token\" value=\"".$_SESSION['token']."\" />
								<div class=\"form-group\">
									<label for=\"title\">Title</label>
    									<input type=\"text\" name=\"title\" id=\"title\" class=\"form-control\" placeholder=\"Title\">
								</div>
								<div class=\"form-group\">
									<label for=\"link\">HTTP Link</label>
    									<input type=\"text\" name=\"link\" id=\"link\" class=\"form-control\" placeholder=\"ex: http://www.google.com\">
								</div>
								<div class=\"form-group\">
									<label for=\"body\">Body</label>
    									<input type=\"text\" name=\"body\" id=\"body\" class=\"form-control\" placeholder=\"Description / Body\">
								</div>    					
  								<button type=\"submit\" class=\"btn btn-light\">Submit</button>
							</form>
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