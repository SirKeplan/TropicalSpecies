<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">

<?php
	function callback($matches) {		
		$key = $matches[1];
		if ($key == "K") {
			$row2 = array("No" => "K", "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips.");

		} else {
			if ($key) {
				$result2 = safe_query("SELECT * FROM `References` WHERE `No` = ".$key);
				$row2 = mysql_fetch_assoc($result2);
			} else {
				return $key;
			}
		}
		$out = "";
		if ($row2) {
			$out = "";
			$out = '<div class="ref"><a href="refs.php#'.$key.'">'.$key.'</a><div>'.OutputBookRefRecord($row2).'</div></div>';

		}
		return $out;
	}

	function link_to_book($string, $other = false) {
		if ($other){			
			$regex = '/(?<=^|,\s)(\d*)/';
		}else {
			$regex = '/(?<=\[|,\s)(\d*|K)(?=,\s|\])/';
		}
		preg_match_all($regex, $string, $matches);

		$rep = array();
		$pat = array();

		$newstring = preg_replace_callback($regex, "callback", $string);

		return $newstring;
	}
	
	include 'functions.php';
	include 'dbconnect.php';
	
	if (empty($_GET["id"])) {
		trigger_error("A plant name must be supplied.");
	}
	$key = mysql_real_escape_string($_GET["id"]);

	$result = safe_query("SELECT * FROM `tropicalspecies` WHERE LCASE(`Latin name`) = LCASE('$key')");
	
	$row = mysql_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['Latin name']." - Useful Tropical Plants</title>";
		echo "</head>\n<body>";	
		include 'header.php';

		global $row;
		include('template.php' );
		echo "<script src=\"boxmove.js\"></script>";
		
	} else {
		echo "<title>".$key."</title>";
		echo "</head>\n<body>";
		include 'header.php';
		echo "<p><b>No record for \"".$key."\"</b></p>";
		
	}
	mysql_free_result($result);
	include 'footer.php';
	mysql_close($db);
?>

</body>
</html>
