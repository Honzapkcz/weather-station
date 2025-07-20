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
<?php include "navbar.php";
if (!$_GET["col"]) {
	$_GET["col"] = "temperature,humidity,water,wind";
}
?>
<div class="content">
<form method="get">
<input type="text" name="col" size="40" value="<?php echo $_GET["col"]; ?>"><br>
</form>
<?php
?>
<img src="./image.png">
<?php
$colors = array("#0ff", "#ff0", "#0ff", "#00f", "#0f0", "#f00");
$data = array();
$columns = explode(",", $_GET["col"]);
foreach ($columns as $col) {
	array_push($data, new data_set($db, $col, array_pop($colors), 100));
}
create_graph("image.png", 600, 300, $data);
?>
</div>
</main>

</body>
</html>
