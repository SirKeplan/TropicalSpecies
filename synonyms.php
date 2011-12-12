<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">

<?php

	function OutputRecord($row) {
		echo "<p><b><i>{$row["LatinName"]}</i></b> {$row["Author"]}</p>\n";
	}
	
	include_once 'functions.php';
	include 'dbconnect.php';

	if (empty($_GET["id"])) {
		trigger_error("A latin name should be specified");
		return;
	}
	$key = mysql_real_escape_string($_GET["id"]);

	$result = safe_query("SELECT * FROM `Synonyms` WHERE `TrueLatinName` = '$key'");

	echo "<title>".$key."</title>\n";
	echo "</head>\n<body>\n";	
	echo '<div class="CONTENT">';
	echo "<h2>Synonyms for $key</h2>\n";

	while ($row = mysql_fetch_assoc($result)) {
		
		if ($row) {
			
			OutputRecord($row);
		} else {
			echo "<title>".$key."</title>";
			echo "</head>\n<body>";
			echo '<div class="CONTENT">';
			include 'header.php';
			echo "<p><b>No record for \"".$key."\"</b></p>";
			
		}
	}
	mysql_free_result($result);

	mysql_close($db);
?>
</div>
</body>
</html>
