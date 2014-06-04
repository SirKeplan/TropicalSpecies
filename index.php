<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Useful Tropical Plants</title>
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
	<div class="mainimage"><img width="200"src="front2.jpg"/>
	<p class="subtext">Carica Papaya (Papaya)<br> growing in a woodland garden.</p>
	</div>
	<p class="mainpage">The <i><b>Useful Tropical Plants Database</b></i> contains information on the edible, medicinal and many other uses of several thousand plants that can be grown in tropical regions.<br><br> 
	It is very much a work in progress, with new records being entered and older records being updated on a regular basis. <br><br> 
	The plants can be browsed using the buttons below (please note that common names are not currently present for most of the records), or it is possible to search on any keyword. There is also a more advanced <a href="query.php">search feature</a> available.<br><br> 
	Any feedback and offers of assistance (especially in obtaining photographs of the plants) will be gratefully received. <br><br>The database currently lists $numPlants species.</p>

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
