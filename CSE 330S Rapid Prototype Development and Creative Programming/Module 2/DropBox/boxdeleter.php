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
	//Start session
	session_start();
	//Initialize Variable
	$user = "";

	//Login checker
	if(isset($_SESSION['logged_in'])){
		if($_SESSION['logged_in']){
			if(isset($_SESSION['user'])){
				$user = $_SESSION['user'];
			}else{
				header("Location: boxlogin.php");
				exit;
			}
		}else{
			header("Location: boxlogin.php");
			exit;
		}
	}else{
		header("Location: boxlogin.php");
		exit;
	}

	//	https://getbootstrap.com/docs/4.1/components/
	//	used the component template for a navbar	
	echo "<nav class=\"navbar navbar-expand-lg navbar-light bg-info\">
  			<a class=\"navbar-brand\" href=\"boxfileview.php\">Home (".$_SESSION['user'].")</a>
  			<div class=\"collapse navbar-collapse\" id=\"navbarNavAltMarkup\">
    				<div class=\"navbar-nav\">
      					<a class=\"nav-item nav-link\" href=\"boxupload.php\">Upload</a>
      					<a class=\"nav-item nav-link\" href=\"boxdeleter.php\">Delete Files</a>
				</div>
				<div class=\"navbar-nav\">
      					<a class=\"nav-item nav-link\" href=\"boxlogout.php\">Log Out</a>
				</div>
			</div>
		</nav>
	";
	
	// Tells user how to delete	
	echo "<div class=\"alert alert-danger\" role=\"alert\">
  		Clicking on a file will delete it!
	</div>
	";
	//	End citation

	// Scans and displays files with links to delete
	$path = "/etc/330class/330Box/boxusers/".$_SESSION['user'];
	$files = scandir($path);
	$list = "";
	for($i=0; $i<count($files); $i++){
		$filename = $files[$i];
		echo "<ul class=\"list-group\">";
		if($filename != "." && $filename != ".."){
			$list .= "<li class=\"list-group-item\"><a href=\"boxtrash.php?file=".$filename."\">".$filename."</a></li>";
		}
		echo "</ul>";
	}	
	echo $list;
	?></p>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>