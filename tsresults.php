<?php
$typed = $_GET["typed"];
	include 'functions.php';
	include 'dbconnect.php';
$result = safe_query($db, "SELECT `Latin name`
FROM `tropicalspecies`
WHERE `Latin name` LIKE '$typed%'");
while ($row = mysqli_fetch_array($result)) {
	echo $row[0].";";
}
	
?>
