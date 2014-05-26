<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Tropical Species Database Index</title>
</head>
<body>

<?php
	include 'functions.php';
	include 'header.php';
	include 'dbconnect.php';
	
echo "<h1>Index of botanical names</h1>\n";
echo '<p class="mainpageletters"><b>';

for ($char = 65; $char <= 90; $char++) {
	echo "<a href=\"letter-index.php?letter=".chr($char)."\">".chr($char)."</a> ";
}
echo "</b></p>\n";

if (empty($_GET["letter"])) {
	echo "<p>Click a letter to list all plants with the botanical names begining with that letter.</p>";
}
else
{
	$key = $_GET["letter"];
	if(preg_match('/^[A-Z]$/',$key)!=1) {
		trigger_error("Invalid letter: \"".htmlspecialchars($key)."\", must be a single character.");
	}
	$pageno = empty($_GET["pageno"]) ? "0" : $_GET["pageno"];
	if(!ctype_digit($pageno)) {
		trigger_error("Invalid pageno: \"".htmlspecialchars($pageno)."\", must be a number.");
	}
	$amount = empty($_GET["amount"]) ? "100" : $_GET["amount"];
	if(!ctype_digit($amount)) {
		trigger_error("Invalid amount: \"".htmlspecialchars($amount)."\", must be a number.");
	}
	
	$q = "SELECT count(*) FROM `tropicalspecies` WHERE SUBSTRING(`Latin name`, 1, 1) = '$key'";
	//echo htmlspecialchars($q);
	$numPlantsRes = safe_query($q);
	$result = safe_query("SELECT `Latin name`,`Common name` FROM `tropicalspecies` WHERE SUBSTRING(`Latin name`, 1, 1) = '$key' ORDER BY `Latin name` ASC LIMIT $pageno, $amount");
	$numPlants = 0;
	$numPlantsRow = mysql_fetch_row($numPlantsRes);
	if($numPlantsRow) {
		$numPlants = $numPlantsRow[0];
	}

	if($numPlants) {
		echo "<p>Showing ".mysql_num_rows($result)." of $numPlants plants beginning with $key.</p>\n";
	}
	else {
		echo "<p>Showing ".mysql_num_rows($result)." plants beginning with $key.</p>\n";
	}

	$http_query = $_GET;

	$http_query["amount"] = $amount;

	nav_controls("letter-index.php", $http_query, $pageno, $amount, $numPlants);

	output_table_query_limited($result, "Nothing", "tropicalspecies",null, "Latin name", "viewtropical.php", "id", -1, array("Latin name", "Common name"));

	nav_controls("letter-index.php", $http_query, $pageno, $amount, $numPlants);
	
}
#mysql_free_result($result);
include 'footer.php';
mysql_close($db);
?>
</body>
</html>
