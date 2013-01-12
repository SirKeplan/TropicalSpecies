
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel=stylesheet href="style.css" type="text/css">

<?php
	
	include_once 'functions.php';
	include 'dbconnect.php';
	$result = safe_query("SELECT * FROM `References`");
	$count = mysql_num_rows($result);
	
	for ($i = 1; $i< $count; $i++) {
		#echo "hi";
		$row = mysql_fetch_assoc($result);
		#print_r($row);
		
		echo "<a name=".$row["No"]."></a><br/><b>Reference: ".$row["No"]."</b>";
		echo OutputBookRefRecord($row);
	}
	
	#$row = mysql_fetch_assoc($result);
	#print_r($row);
	#OutputBookRefRecord($row);
	
	
	mysql_close($db);


?>
</div>
</body>
</html>
