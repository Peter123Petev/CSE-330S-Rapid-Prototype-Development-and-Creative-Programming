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

	// Start Session
	session_start();
	// Initialize Variable
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
	?></p>
	<?php
		//	https://getbootstrap.com/docs/4.1/components/
		//	used the component template for cards	
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
		//	End Citation
	?>
	<p></p>
	<!--	Uploader Form -->
	<form enctype="multipart/form-data" action="boxuploader.php" method="POST">
		<div class="form-group text-center">
			<p>
				<input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
				<label for="uploadfile_input">Choose a file to upload:</label>
				<input name="uploadedfile" type="file" id="uploadfile_input" class="btn btn-info"/>
			</p>
			<p>
				<input type="submit" value="Upload File" class="btn btn-info"/>
			</p>
		</div>
	</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>