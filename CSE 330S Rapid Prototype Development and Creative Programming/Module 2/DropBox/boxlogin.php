<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body>

<!––	https://getbootstrap.com/docs/4.1/components/	-->
<!––	used the component template for a two card layout		-->
<form action="boxinfo.php" method="POST">
<div class="card bg-info text-right">
  <div class="card-body">
	<p>
		<label for="usernameinput">Username:</label>
		<input type="string" name="username" id="usernameinput" />
		<input type="submit" value="Log In" />
		<a href="boxregister.php" class="badge badge-info">Register</a>
	</p>
	</div>
</div>
<div class="card bg-light text-center">
  <div class="card-body">
	<h1>330 Box</h1>
	<p>
		The best 330 Module 2 assignment ever.
	</p>
	</div>
</div>
</form>
<!––	End citation					-->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>