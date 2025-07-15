<?php
	use Medoo\Medoo;

	require "./graflib.php"; # our graffic lib

	$db = new Medoo([
		"type" => "sqlite",
		"database" => "data.db",
	]);



	$data = array(
		new data_set($db, "temperature",	"#f00"),
		new data_set($db, "humidity",		"#0fa")
	);
	create_graph("img.png",500,250,$data);
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Weather Station</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body class="index">
		<a href="./home.php">Old website</a>
	</body>
</html>
