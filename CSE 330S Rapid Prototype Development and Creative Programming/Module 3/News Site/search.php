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
			//Start the session, set logged variable to false
			session_start();
			$logged_in = $_SESSION['logged_in'];
			$user = $_SESSION['user'];
			$search_term = $_POST['filter'];

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

			//Don't do search if term is blank
			if(empty(htmlentities($search_term))){
				echo "Empty search!";
				header("Location: home.php");
				exit;
			}

			echo "<h1 class=\"text-center\">Results for search term \"".htmlentities($search_term)."\"</h1>";
			echo "<ul class=\"list-group\">";

			$stmt = $mysqli->prepare("select stories.*, accounts.user from stories join accounts on (stories.author_id=accounts.user_id);");
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_id, $author_id, $story_title, $story_body, $story_link, $story_author);

			//Go through all of the rows to see if term comes up, then show
			while($stmt->fetch()){
				if(strpos(strtolower(htmlentities($story_title)), strtolower(htmlentities($search_term))) !== false){
					echo "
						<li class=\"list-group-item\">
							The Story, \"<a href=\"storyview?story_id=".htmlentities($story_id)."\">".htmlentities($story_title)."</a>\" contains your term.</li>
					";
				}
			}

			$stmt = $mysqli->prepare("select user from accounts;");
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($user_name);

			while($stmt->fetch()){
				if(strpos(strtolower(htmlentities($user_name)), strtolower(htmlentities($search_term))) !== false){
					echo "
						<li class=\"list-group-item\">The User, \"<a href=\"profile?viewuser=".htmlentities($user_name)."\">".htmlentities($user_name)."</a>\" contains your term.</li>
					";
				}
			}

			$stmt = $mysqli->prepare("select stories.title,stories.story_id,comment,accounts.user from comments join accounts on (comments.author_id=accounts.user_id) join stories on (stories.story_id=comments.story_id);");
		
			if(!$stmt){
				printf("Query Prep Failed: %s\n", $mysqli->error);
				exit;
			}

			$stmt->execute();

			$stmt->bind_result($story_title,$story_id,$comment,$comment_author);

			while($stmt->fetch()){
				if(strpos(strtolower(htmlentities($comment)), strtolower(htmlentities($search_term))) !== false){
					echo "
						<li class=\"list-group-item\">".htmlentities($comment_author)."'s Comment, \"<a href=\"storyview?story_id=".$story_id."\">".htmlentities($comment)."</a>\" on the Story, \"".htmlentities($story_title)."\" contains your term.</li>
					";
				}
			}
			echo "</ul>";
		?>
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	</body>
</html>