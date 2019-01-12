<!DOCTYPE html>
<html lang="en">
<head>
	<title>Calculator Results</title>
</head>
<body>
	<p><?php
	$first = (float) $_POST['firstnumber'];
	$second = (float) $_POST['secondnumber'];
	$operation = $_POST['operation'];
	$result = 0;

	echo $first;
	switch ($operation) {
		case "addition":
			$result = ($first+$second);
			echo " + ";
		break;
		case "subtraction":
			$result = ($first-$second);
			echo " - ";
		break;
		case "multiplication":
			$result = ($first*$second);
			echo " * ";
		break;
		case "division":
			$result = ($first/$second);
			echo " / ";
			if($second == 0) {
				$result = "undefined";
			}
		break;
		default:
		break;
	}
	echo $second;
	echo " = ";
	echo $result;
	?></p>
	<p><a href="calculator.html">New Calculation</a></p>
</body>
</html>