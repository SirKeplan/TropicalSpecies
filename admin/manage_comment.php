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
	include '../functions.php';
	include '../dbconnect.php';
	#include '../header.php';

	$op = $_GET["op"];
	$id = $_GET["id"];
	if ($op == "a") {
		safe_query("UPDATE `TropicalSpeciesDB`.`Comments` SET `Approved` = '1' WHERE `Comments`.`ID` =$id;");
		echo "Done.";
	}else if ($op == "d") {
		safe_query("DELETE FROM `TropicalSpeciesDB`.`Comments` WHERE `Comments`.`ID` = $id AND `Approved` = '0'");
		if (mysql_affected_rows() > 0) {			
			echo "Record deleted.";
		} else {
			echo "Could not be deleted.";
		}
		
	}
	mysql_close($db);	

?>

</body>
</html>