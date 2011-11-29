<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">
  <title>Tropical Species Database Index</title>
</head>
<body>
<?php
	include 'header.php';
	//include 'dbconnect.php';
	//include '../medicinal/functions.php';
	//echo "<h1>Tropical Database</h1>\n";
	
	/*
	$result = mysql_query("SELECT * FROM `tropicalspecies`"); 
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
	
	echo "<p><b>";
	#echo chr(65);#.to_string();
	 for ($char = 65; $char <= 90; $char++) {
		echo "<a href=\"common-index.php?letter=".chr($char)."\">".chr($char)."</a> ";
	}
	echo "</b></p>\n";
	#$result = mysql_query("SELECT * FROM `tropicalspecies`");
	$key = $_GET["letter"];
	$res = mysql_query("SELECT `Common name` FROM `tropicalspecies` WHERE `Common name` = '$key'");
	$count = mysql_num_rows($res);
	if ($key == "") {
		echo "Click a letter to view all plants with the Common name starting with it.";
		
		echo "<br/>".$count." plants in this database have common names.";
		
		include 'footer.php';
		return;
	}
	//++++
	
	$pageno = $_GET["pageno"];
	$amount = $_GET["amount"];
	if ($pageno == "" || $amount == "") {
		$amount = 100;
		$pageno = 0;
	}
	$all = mysql_query("SELECT * FROM `tropicalspecies` WHERE SUBSTRING(`Common name`, 1, 1) = '$key' ORDER BY `Common name` ASC"); 
	$result = mysql_query("SELECT * FROM `tropicalspecies` WHERE SUBSTRING(`Common name`, 1, 1) = '$key' ORDER BY `Common name` ASC LIMIT $pageno, $amount"); 
	$allcount = mysql_num_rows($all);
	
	//echo "<p>";
	
	echo "Showing ".mysql_num_rows($result)." of ".$allcount." plants beginning with $key<br><br>";
	/*echo "Page ".(($pageno/$amount)+1)." of ".ceil(($allcount/$amount))." ";
	if ((($pageno/$amount)+1) > 1) {
		echo "<a href=\"common-index.php?letter=$key&amp;pageno=".($pageno-$amount)."&amp;amount=".($amount)."\">Prev page</a> ";
	}
	if ((($pageno/$amount)+1) < ceil(($allcount/$amount))) {
		echo "<a href=\"common-index.php?letter=$key&amp;pageno=".($pageno+$amount)."&amp;amount=".($amount)."\">Next page</a> ";

	}
	*/
	$http_query = $_GET;
		
	//echo "<p>".mysql_num_rows($all)." records.</p>";
		
		
	$http_query["amount"] = $amount;
	
	nav_controls("common-index.php", $http_query, $pageno, $amount, $allcount);
	//echo "</p>";

	//++++
	
	
	
	//$result = mysql_query("SELECT * FROM `tropicalspecies` WHERE SUBSTRING(`Common name`, 1, 1) = '$key' ORDER BY `Common name` ASC"); 
	//echo "Showing ".mysql_num_rows($all)." plants beginning with $key.";
	output_table_query_limited($result, "Nothing", "tropicalspecies",null, "Common name", "viewtropical.php", "id", -1, array("Common name", "Latin name"), "Latin name");
	
	#mysql_free_result($result);
	include 'footer.php';
	mysql_close($db);
?>
</body>
</html>
