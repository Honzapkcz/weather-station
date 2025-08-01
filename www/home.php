<!DOCTYPE html>
<html>
<head>
<?php
require("graflib.php");
use Medoo\Medoo;
# CREATE TABLE data (id INTEGER PRIMARY KEY AUTOINCREMENT, time INTEGER DEFAULT CURRENT_TIMESTAMP, temperature INTEGER, humidity INTEGER, wind INTEGER, water INTEGER);
$db = new Medoo([
	"type" => "sqlite",
	"database" => "data.db",
]);

?>
<title>Weather Station</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<main>
<?php include "navbar.php"; ?>
<div class="content">
<img src="./image.png">
<?php
	$data = array(
		new data_set($db, "temperature", "#fff", 100),
		new data_set($db, "humidity", "#f0f", 100),
	);
	
	create_graph("image.png", 600, 300, $data);
?>
</div>
</main>

</body>
</html>
