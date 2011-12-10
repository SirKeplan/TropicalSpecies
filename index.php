<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">
  <title>Tropical Species Database Index</title>
</head>
<body>
<?php
	include 'functions.php';
	include 'dbconnect.php';
	include 'header.php';

	/*
	$result = safe_query("SELECT * FROM `tropicalspecies`"); 
	echo "<p><b>Last update on 04/03/11:</b> Now containing ".mysql_num_rows($result)." plants.</p>\n	";
	echo "<p><a href=\"query.php\">Search</a></p>";
	*/
	//04/03/11  4580
	//02/02/11  4292
	//26/12/10	4117
	//echo "<p><b>Revision 3:</b> Now containing ".mysql_num_rows($result)." plants.<br>\n	";
	//echo "<b>Revision 2:</b> Contained 3940 plants.<br>\n	";
	//echo "<b>Revision 1:</b> Contained 3681 plants.<br>\n	";
	//echo "Original Contained 3552 plants.</p>";	
	$numPlants = 5500;
	$numPlantsRes = safe_query("SELECT count(*) FROM `tropicalspecies`");
	$numPlantsRow = mysql_fetch_row($numPlantsRes);
	if($numPlantsRow) {
		$numPlants = $numPlantsRow[0];
	}
	echo <<<EOT
	<p class="mainpage">The Tropical Species Database is a database of useful plant
	which can be grown in tropical regions. 
	It contains details of the edible medicinal and other uses and lists over $numPlants plants.</p>

	<form action="query.php" method="get">
	<div id="mainsearchbox">
	<input type="text" name="full"
		value="Search:" onfocus="togglePrompt(this.searchbox, true)"
		alt="Search" onblur="togglePrompt(this.searchbox, false)" />
	<input type="submit" value="Submit" />
	</div>
	</form>
	
	<p class="mainpage">Browse botanical names:</p>
	
EOT;
	echo '<p class="mainpageletters"><b>';
	#echo chr(65);#.to_string();
	for ($char = 65; $char <= 90; $char++) {
		echo "<a href=\"letter-index.php?letter=".chr($char)."\">".chr($char)."</a> ";
	}
	echo "</b></p>\n";
	echo '<p class="mainpage">Browse common names</p>';
	echo '<p class="mainpageletters"><b>';
	#echo chr(65);#.to_string();
	for ($char = 65; $char <= 90; $char++) {
		echo "<a href=\"common-index.php?letter=".chr($char)."\">".chr($char)."</a> ";
	}
	echo "</b></p>\n";
	
	echo '<p class="mainpage"><a href="query.php">Advanced search</a>: allows search by habitat and growing conditions.</p>';
	
	include 'footer.php';
	mysql_close($db);	

?>

</body>
</html>
