<!--
<form action="home.php" method="get">
	<div class="nav">
		<input type="submit" name="action" value="Overview">
		<input type="submit" name="action" value="Temperature">
		<input type="submit" name="action" value="Humidity">
		<input type="submit" name="action" value="Wind Speed">
		<input type="submit" name="action" value="Water Level">
		<input type="submit" name="action" value="Insert Value">
		<input type="submit" name="action" value="Back" formaction="/">
	</div>
</form>
-->
<div class="nav">
	<a href="index.php">Overview</a>
	<details>
		<summary>Values</summary>
		<a href="index.php?column=temperature">Temperature</a>
		<a href="index.php?column=humidity">Humidity</a>
		<a href="index.php?column=wind">Wind Speed</a>
		<a href="index.php?column=water">Precipitation</a>
	</details>
	<a href="table.php">Table</a>
	<a href="select.php">Graph</a>
	<a href="insert.php">Insert</a>
</div>
