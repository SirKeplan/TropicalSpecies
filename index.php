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
	
	echo "<p>This is the about page, it should have some information on it</p>";
		include 'footer.php';

	mysql_close($db);	

?>

</body>
</html>
