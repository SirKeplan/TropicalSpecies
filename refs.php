<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>References - Useful Tropical Plants</title>
</head>
<body>
<div>
<?php
	include_once 'functions.php';
	include 'dbconnect.php';
	include 'header.php';
	
	$result = safe_query("SELECT * FROM `References`");
	$count = mysql_num_rows($result);
	
	for ($i = 1; $i< $count; $i++) {
		#echo "hi";
		$row = mysql_fetch_assoc($result);
		#print_r($row);
		
		echo "<a name=".$row["No"]."></a><br/><b>Reference: ".$row["No"]."</b>";
		echo OutputBookRefRecord($row);
		echo "<br/>";
	}
	
	#$row = mysql_fetch_assoc($result);
	#print_r($row);
	#OutputBookRefRecord($row);
	
	include 'footer.php';

	mysql_close($db);


?>
</div>
</body>
</html>
