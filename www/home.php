<?php
	require "Medoo.php";
	require "./phpgraphlib.php";
	use Medoo\Medoo;
	class data_set
	{
		public $column_name;
		public $data;
		public $times;
		public $color;
		function __construct($database, $column, $color) {
			$this->column_name = $column;
			$this->color = $color;
			$this->data = [];
			$this->times = [];
		
			$database_select = $database->select("data", array("time",$column), ["LIMIT" => [0, 144]]); #last 12h of data
			foreach ($database_select as $column_data) {
				array_push($this->data,$column_data[$column]);
				array_push($this->times,$column_data["time"]);
			}
		}
	}
	function create_graph($file_name, $x_size, $y_size, $data) {
		$graph = new PHPGraphLib($x_size, $y_size, $file_name);

		$graph->setTextColor("white");
		$graph->setBackgroundColor("black");
		$graph->setBars(false);

		$graph->setLine(true);

		foreach ($data as $data_set) {
			$graph->addData($data_set->data);
			$graph->setLineColor($data_set->color);
		}
		$graph->createGraph();
	}




	$db = new Medoo([
		"type" => "sqlite",
		"database" => "data.db",
	]);
	$data = array(
		new data_set($db, "temperature",	"#f00"),
		new data_set($db, "humidity",		"#0fa")
	);

	create_graph("img.png",300,200,$data);
?>
<img src="./img.png">
