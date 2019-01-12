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

			//show current like toggle
			$liked = false;
			$stmt = $mysqli->prepare("select * from likes where story_id = ?;");
			$safe_story_id = $mysqli->real_escape_string($_GET['story_id']);
			$stmt->bind_param('i', $safe_story_id);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->execute();
			$stmt->bind_result($like_id, $liked_story_id, $liker_id);

			while($stmt->fetch()){
				if((int)trim($liker_id) - (int)trim($_SESSION['user_id']) == 0){
					$liked = true;
				}
			}

			//show the current story
			$stmt = $mysqli->prepare("select stories.*, accounts.user from stories join accounts on (stories.author_id=accounts.user_id) where story_id = ?;");
			$stmt->bind_param('i', $safe_story_id);
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}
			$stmt->execute();
			$stmt->bind_result($story_id, $author_id, $story_title, $story_body, $story_link, $story_author);

			while($stmt->fetch()){
				echo "
					<h1 class=\"text-center\">".htmlentities($story_title)."</h1>
					<h6 class=\"text-center\">By: <a href=\"profile?viewuser=".htmlentities($story_author)."\">".htmlentities($story_author)."</a></h6>
				";
				if($_SESSION['logged_in']){
					echo "<p class=\"text-center\">";
					if($liked){
						echo "<a href=\"liketoggle?like=false&story=".htmlentities($story_id)."\">Unlike</a>";
					}else{
						echo "<a href=\"liketoggle?like=true&story=".htmlentities($story_id)."\">Like</a>";
					}
					echo "</p>";
				}

				echo "
					<div class=\"card w-75 mx-auto\">
  						<div class=\"card-header\">
							Link: <a href=\"".htmlentities($story_link)."\" target=\"blank\">".htmlentities($story_link)."</a>
						</div>
						<div class=\"card-body\">
							<h6>".htmlentities($story_body)."</h6>
						</div>
					</div>
				";
			}

			echo "<hr>";

			//show comments
			$stmt = $mysqli->prepare("select stories.story_id, accounts.user, comment from comments join stories on (comments.story_id=stories.story_id) join accounts on  (comments.author_id=accounts.user_id) where stories.story_id = ?;");
			$stmt->bind_param('i', $safe_story_id);

			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_id, $comment_writer, $comment);

			while($stmt->fetch()){
				echo "
					<div class=\"card w-50 mx-auto\">
						<div class=\"card-body\">
							<a href=\"profile?viewuser=".htmlentities($comment_writer)."\" class=\"btn btn-light\">".htmlentities($comment_writer).":</a> ".htmlentities($comment)."
						</div>
					</div>
				";
			}

			echo "<hr>";

			//allow current user to comment if they are logged in
			if($logged_in){
				echo "
					<div class=\"card w-50 mx-auto\">
						<div class=\"card-body\">
							<form action=\"writecomment.php\" method=\"POST\">
								<input type=\"hidden\" name=\"token\" value=\"".$_SESSION['token']."\" />
								<div class=\"form-group\">
									<label for=\"comment\">Comment</label>
    									<input type=\"text\" class=\"form-control-file\" name=\"comment\" id=\"comment\">
									<input type=\"hidden\" name=\"story_id\" id=\"story_id\" value=\"".htmlentities(htmlentities($_GET['story_id']))."\">
								</div>
								<button type=\"submit\" class=\"btn btn-light\">Submit</button>
							</form>
						</div>
					</div>
				";
			}
		?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>