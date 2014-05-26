<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
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
	<img class="mainimage" src="front.png"/>
	<p class="mainpage">The Tropical Species Database is a database of useful plants
	which can be grown in tropical regions. 
	It contains details of the edible medicinal and other uses and currently lists $numPlants species.</p>

	<div id="mainsearchbox">
	<form action="query.php" method="get">
	<input type="text" id="searchbox2" name="full"
		value="Search:" onfocus="togglePrompt(searchbox2, true)"
		alt="Search" onblur="togglePrompt(searchbox2, false)" />
	<input type="submit" value="Search" />
	</form>
	</div>
	
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
	/*
	echo '<p class="mainpage"><a href="query.php">Advanced search</a>: allows search by habitat and growing conditions.</p>';
	
	echo '
	<form action="query.php" method="get"><div><input type="text" class="searchbox" id="searchbox2" name="full"  
    value="Search:" onfocus="togglePrompt(searchbox2, true)" 
    alt="Search" onblur="togglePrompt(searchbox2, false)" > <input type="submit" value="Search"></div></form>
	';
	*/
	include 'footer.php';
	mysql_close($db);	

?>

</body>
</html>
