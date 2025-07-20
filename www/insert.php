<!DOCTYPE html>
<html>
<head>
<title>Weather Station</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
<?php include "navbar.php"; ?>
<div>
<form method="get">
	<label for="temp">Temperature: </label>
	<input type="number" name="temp" value="20" id="temp"><br>
	<label for="humi">Humidity: </label>
	<input type="number" name="humi" value="60" id="humi"><br>
	<label for="water">Water Level: </label>
	<input type="number" name="water" value="50" id="water"><br>
	<label for="wind">Wind Speed: </label>
	<input type="number" name="wind" value="10" id="wind"><br>
	<input type="submit" value="Insert Value">
</form>
<?php
require "Medoo.php";
use Medoo\Medoo;
if ($_GET["temp"]) {
	echo "<p>Data Insertion Is Not Allowed</p>";
	$db = new Medoo([
		"type" => "sqlite",
		"database" => "data.db",
	]);
	# $db->insert("data", [
	# 	"temperature" => $_GET["temp"],
	# 	"humidity" => $_GET["humi"],
	# 	"water" => $_GET["water"],
	# 	"wind" => $_GET["wind"],
	# ]);

}
?>
</div>
</main>
</body>
</html>
