<?php
	require "Medoo.php";
	require "./phpgraphlib.php";
	use Medoo\Medoo;
	class data_set
	{
		public $column_name;
		public $data;
		public $color;
		public $smallest;
		public $biggest;
		function __construct($database, $column, $color, $count) {
			$this->column_name = $column;
			$this->color = $color;
			$this->data = [];
			$database_select = $database->select(
				"data",
				array("time",$column),
				[
					"LIMIT" => [0, $count],
					"ORDER" => [
						    "time" => "DESC",
						]      
				]
			);

			$this->smallest = 9999999;
			$this->biggest = 0;
			foreach ($database_select as $column_data) {
				if($this->smallest > $column_data[$column])
					$this->smallest =$column_data[$column];
				if($this->biggest < $column_data[$column])
					$this->biggest =$column_data[$column];

				array_push($this->data,$column_data[$column]);
			}
		}
	}
	function create_graph($file_name, $x_size, $y_size, $data) {
		$graph = new PHPGraphLib($x_size, $y_size, $file_name);

		$graph->setTextColor("white");
		$graph->setBackgroundColor("black");
		$graph->setBars(false);

		$graph->setGrid(false);

		$graph->setXValues(false);
		$graph->setLine(true);

		$smallest = 9999;
		$biggest = 0;
		foreach ($data as $data_set) {

			if($smallest > $data_set->smallest) {
				$smallest = $data_set->smallest;
			}
			if($biggest < $data_set->biggest) {
				$biggest = $data_set->biggest;
			}

			$graph->addData($data_set->data);
			$graph->setLineColor($data_set->color);
		}
		$graph->setRange($biggest + 1,$smallest - 1);
		$graph->createGraph();
	}
	function generate_table($database,$columns,$count) {
		$database_select = $database->select(
			"data",
			$columns,
			[
				"LIMIT" => [0, $count],
				"ORDER" => [
					    "time" => "DESC",
					]      
			]
		);

		echo "<table>";
		foreach ($database_select as $data) {
			echo "<tr>";
			foreach ($data as $row) {
				echo "<td>$row</td>";
			}
			echo "</tr>";
		}
		echo "</table>";
	}

/* 	$db = new Medoo([ */
/* 		"type" => "sqlite", */
/* 		"database" => "data.db", */
/* 	]); */
/* 	$data = array( */
/* 		new data_set($db, "temperature",	"#f00"), */
/* 		new data_set($db, "humidity",		"#0fa") */
/* 	); */
/**/
/* 	create_graph("img.png",300,200,$data); */
/* <img src="./img.png"> */
