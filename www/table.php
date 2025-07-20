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
	$_GET["col"] = "id,time,temperature,humidity,water,wind";
}
?>
<div class="content">
<form method="get">
<input type="text" name="col" size="40" value="<?php echo $_GET["col"]; ?>"><br>
</form>
<?php
$data = array();
$columns = explode(",", $_GET["col"]);
generate_table($db, $columns, 100000);
?>
</div>
</main>

</body>
</html>
