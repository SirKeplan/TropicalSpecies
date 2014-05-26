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

echo "<h1>Index of common names</h1>\n";
echo '<p class="mainpageletters"><b>';

for ($char = 65; $char <= 90; $char++) {
	echo "<a href=\"common-index.php?letter=".chr($char)."\">".chr($char)."</a> ";
}
echo "</b></p>\n";

if (empty($_GET["letter"])) {
	echo "<p>Click a letter to list all plants with the common names starting with that letter.</p>";

	echo "<p>Not all plants have their common name in the database, and many plants have multiple common names.<br>Only one common name is given for each plant in the database.</p>";

	$numPlantsRes = safe_query("SELECT count(*) FROM `tropicalspecies` WHERE `Common name` <> ''");
	$numPlants = 0;
	$numPlantsRow = mysql_fetch_row($numPlantsRes);
	if($numPlantsRow) {
		$numPlants = $numPlantsRow[0];
		echo "<p>".$numPlants." plants in this database have common names.</p>";
	}
}
else
{
	$key = $_GET["letter"];
	if(preg_match('/^[A-Z]$/',$key)!=1) {
		trigger_error("Invalid letter: \"".htmlspecialchars($key)."\", must be a single character.");
	}
	
	$pageno = empty($_GET["pageno"]) ? 0 : $_GET["pageno"];
	if(preg_match('/^\d+$/',$pageno)!=1) {
		trigger_error("Invalid pageno: \"".htmlspecialchars($pageno)."\", must be a number.");
	}
	$amount = empty($_GET["amount"]) ? 100 : $_GET["amount"];
	if(preg_match('/^\d+$/',$amount)!=1) {
		trigger_error("Invalid amount: \"".htmlspecialchars($amount)."\", must be a number.");
	}

	$numPlantsRes = safe_query("SELECT count(*) FROM `tropicalspecies` WHERE SUBSTRING(`Common name`, 1, 1) = '$key'");
	$result = safe_query("SELECT `Latin name`,`Common name` FROM `tropicalspecies` WHERE SUBSTRING(`Common name`, 1, 1) = '$key' ORDER BY `Common name` ASC LIMIT $pageno, $amount");
	$numPlantsRow = mysql_fetch_row($numPlantsRes);
	
	if($numPlantsRow) {
		$allcount = $numPlantsRow[0];
	}

	echo "<p>Showing ".mysql_num_rows($result)." of ".$allcount." plants beginning with $key</p>";

	$http_query = $_GET;

	$http_query["amount"] = $amount;

	nav_controls("common-index.php", $http_query, $pageno, $amount, $allcount);
	output_table_query_limited($result, "Nothing", "tropicalspecies",null, "Common name", "viewtropical.php", "id", -1, array("Common name", "Latin name"), "Latin name");
	nav_controls("common-index.php", $http_query, $pageno, $amount, $allcount);
	
}
#mysql_free_result($result);
include 'footer.php';
mysql_close($db);
?>
</body>
</html>
