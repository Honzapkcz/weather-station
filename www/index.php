<!DOCTYPE html>
<html>
<head>
<?php
require "Medoo.php";
require "./phpgraphlib.php";
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
<form action="index.php" method="get">
	<div class="nav">
		<input type="submit" name="action" value="Overview">
		<input type="submit" name="action" value="Temperature">
		<input type="submit" name="action" value="Humidity">
		<input type="submit" name="action" value="Wind Speed">
		<input type="submit" name="action" value="Water Level">
		<input type="submit" name="action" value="Insert Value">
	</div>
</form>
<div class="content">
<?php
$h = $_GET["action"];
$columns = [];
echo "<h1>$h</h1>";

if ($h == "Insert Value") {
	if ($_GET["temperature"]) {
		echo "<p>Data Inserted</p>";
		$db->insert("data", [
			"temperature" => $_GET["temperature"],
			"humidity" => $_GET["humidity"],
			"water" => $_GET["water"],
			"wind" => $_GET["wind"],
		]);
	}
	include "insert.php";
} else {
	switch ($h) {
	case "Overview":
		$columns = ["time", "temperature", "humidity", "water", "wind"];
		break;
	case "Temperature":
		$columns = ["time", "temperature"];
		break;
	case "Humidity":
		$columns = ["time", "humidity"];
		break;
	case "Wind Speed":
		$columns = ["time", "wind"];
		break;
	case "Water Level":
		$columns = ["time", "water"];
		break;
	}
	if ($columns != []) {
		$data = $db->select("data", $columns);

?>
<img src="./image.png">
<?php

		echo "<table><tr>";

		foreach ($columns as $col) {
			echo "<th>$col</th>";
		}
		echo "</tr>";
		$gd = [];
		foreach ($data as $row) {
			echo "<tr>";
			foreach ($columns as $col) {
				echo "<td>$row[$col]</td>";
			}

				array_push($gd, $row[$columns[1]]);
			echo "</tr>";
		}
		echo "</table>";

		$graph = new PHPGraphLib(500, 250,"image.png");

		$orange = "#f50";


		$graph->setTextColor("white");
		$graph->setBackgroundColor("black");

		$graph->setDataValues(true);
		$graph->setDataValueColor($orange);

		$graph->setBars(false);

		$graph->setDataPoints(true);
		$graph->setDataPointColor($orange);

		$graph->setLine(true);
		$graph->setLineColor($orange);


		$graph->addData($gd);
		$graph->setTitle($h);
		$graph->createGraph();

	}
}

?>
</div>
</main>

</body>
</html>
