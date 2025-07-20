<?php
	use Medoo\Medoo;
	require "./graflib.php"; # our graffic lib

	$db = new Medoo([
		"type" => "sqlite",
		"database" => "data.db",
	]);

	$count = (is_numeric($_GET["count"])) ? $_GET["count"] : 360; # How much data is displayed
	$data = []; # Data that graph is created from
	$columns = []; # Name of columns that should be displayed
	
	if(sizeof($_GET["column"]) > 0){ # Is there something in "column"
		$columns = explode(",", $_GET["column"]);
		foreach($columns as $url_column) {
			switch($url_column) { # For each "column" it searcches the data
				case "temperature": 	array_push($data,new data_set($db, "temperature",	"#f00", $count));break;
				case "humidity": 	array_push($data,new data_set($db, "humidity",		"#0db", $count));break;
				case "water": 		array_push($data,new data_set($db, "water",		"#00f", $count));break;
				case "wind": 		array_push($data,new data_set($db, "wind",		"#fff", $count));break;
				default: echo "<h>There is something wrong</h>";
			}
		}
	}else{
		# Default case when there are no additional parameters
		$columns = array("temperature","humidity","water","wind");
		$data = array(
			new data_set($db, "temperature","#f00", $count),
			new data_set($db, "humidity",	"#0bd", $count),
			new data_set($db, "water",	"#00f", $count),
			new data_set($db, "wind",	"#fff", $count),
		);
	}
	create_graph("img.png",2000,500,$data); # Generates image from the data
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Weather Station</title>
		<link rel="stylesheet" href="styles.css">
	</head>
	<body>
		<main>
		<?php include "navbar.php";?>
			<div class="index_container">
				<img src="./img.png" style="image-rendering: smooth;">
				<div class="owerflow">
					<?php
						array_unshift($columns,"time"); # appends "time" to begening of the array ["time",...
						generate_table($db,$columns, $count); # creates table
					?>
					<h>To get more/lesl data use: "count"</h>
				</div>
			</div>
		</main>
	</body>
</html>
