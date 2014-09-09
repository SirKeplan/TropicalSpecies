<?php
// use an output buffer to store page contents
ob_start();
?>
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
			$out = '<div class="ref"><a href="javascript:;" >'.$key.'</a><div class=".entry-unrelated">'.OutputBookRefRecord($row2).'</div></div>';
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
		emailError(51, "A plant name must be supplied.",$_SERVER['REQUEST_URI'],"","");
		//redirect to index page
		header('Location: ./', TRUE, 303);
		die;
	}
	$key = mysql_real_escape_string($_GET["id"]);

	$redir = null;
	if (! empty($_GET["redir"])) {
		$redir = mysql_real_escape_string($_GET["redir"]);
	}

	$result = safe_query("SELECT * FROM `tropicalspecies` WHERE LCASE(`Latin name`) = LCASE('$key')");
	
	$row = mysql_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['Latin name']." - Useful Tropical Plants</title>";
		echo "</head>\n<body>";	
		include 'header.php';

		global $redir;
		global $row;
		include('template.php' );
		echo "<script src=\"boxmove.js\"></script>";
		
	} else {
		echo "<title>No Record - Useful Tropical Plants</title>";
		echo "</head>\n<body>";
		include 'header.php';
		$names = array();
		#mysql string comparisons aren't case sensitive, no need to convert case
		$synresult = safe_query('SELECT * FROM `Synonyms`WHERE `LatinName` = "'.$key.'"');
		while ($row = mysql_fetch_assoc($synresult)) {
			$names[] = $row["TrueLatinName"];
		}
		if (count($names) < 1) {
			echo "<p>We have no record for <b>\"".htmlspecialchars($key)."\"</b></p>";
			echo "<p>Try running a search.</p>";

		} else if (count($names) == 1) {
			#redirect...
			header('Location: viewtropical.php?id='.urlencode($names[0]).'&redir='.urlencode($key), TRUE, 303);
			#script shouldn't actualy reach here in theory
			echo '<p>You probably want:';
			echo '<a href="viewtropical.php?id='.urlencode($names[0]).'&redir='.urlencode($key).'">'.$names[0].'</a>';
			echo '</p>';
		}else {
			echo "<p>No record for <b>\"".$key."\"</b></p>";
			echo "<p>\"$key\" is a synonym of the following plants.</p>";
			mysql_data_seek($synresult, 0);
			output_table_query($synresult, "Nothing", "Synonyms", null, "TrueLatinName", "viewtropical.php", "id",-1 , array("LatinName"), array("TrueLatinName" => "Latin Name", "Author" => "Author"));
			#print_r( $names);
		}
		
	}
	mysql_free_result($result);
	include 'footer.php';
	mysql_close($db);
	ob_end_flush();
?>

</body>
</html>
