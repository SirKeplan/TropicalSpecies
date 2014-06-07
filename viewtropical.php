<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">

<?php
	function callback($matches) {
		
		#echo "|";
		#print_r( $matches);
		#echo "|";
		
		$key = $matches[1];
		
		if ($key == "K") {
			$row2 = array("No" => "K", "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips.");

			#mysql_close($db);
			#return;
		} else {
			if ($key) {
				$result2 = safe_query("SELECT * FROM `References` WHERE `No` = ".$key);
				$row2 = mysql_fetch_assoc($result2);
				#echo $row2["Title"];
			} else {
				return $key;
			}
		}
		$out = "";
		if ($row2) {
			$out = "";
			$out = '<div class="ref"><a href="refs.php#'.$key.'">'.$key.'</a><div class=".entry-unrelated">'.OutputBookRefRecord($row2).'</div></div>';
			
			#$out .= OutputBookRefRecord($row2);
			#$out .= 
		}
		#echo "function:";
		#echo htmlspecialchars ($out);
		return $out;//$matches[0];//$matches[0];
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
		#$out = "";
		/*
		for ($i = 0; $i < count($matches[1]); $i++) {
			$pat[$i] = $regex;#"/{$matches[$i]}/";
			$rep[$i] = '<a href="bookref.php?id=$1" onClick="RefWindow=window.open(\'bookref.php?id=$1\',\'RefWindow\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=610,left=50,top=150\'); RefWindow.focus(); return false;">$1</a>';
			
			$key = $matches[1][$i];
			$row2 = null;
			$row2 = array("No" => $key, "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips.");

			
			
			if ($key == "K") {
				$row2 = array("No" => "K", "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips.");

				#mysql_close($db);
				#return;
			} else {
				if ($key) {
					$result2 = safe_query("SELECT * FROM `References` WHERE `No` = ".$key);
					$row2 = mysql_fetch_assoc($result2);
					#echo $row2["Title"];
				}
			}
			
			if ($row2) {
				$rep[$i] = "";
				$rep[$i] .= '<span class="ref"><a href="#">$1</a><span>';
				$rep[$i] .= OutputBookRefRecord($row2);
				$rep[$i] .= '</span></span>';
				#$rep[$i] = $out;
			}
			#echo "INDEX~~".$i."</br>";

			
		}
		*/
		#print_r ($rep);
		$newstring = preg_replace_callback($regex, "callback", $string);
		#$newstring = preg_replace($pat, $rep, $string);
		#$newstring = str_replace($matches[1], $rep, $string);
		return $newstring;
	}


	function OutputRecord($row) {
		#$order = array( "Latin name","Common name","Author",
		#				"Botanical references","Family","Range",
		#				"Habitat","Known hazards","Cultivation details",
		#				"Edible uses","Uses notes","Medicinal",
		#				"Propagation 1","WeedPotential",
		#				"ConservationStatus","AgroforestryUses",
		#				"NomenclatureNotes","GeneralInformation");
		#echo "<p>";
		#foreach ($order as $col) {
		#	print_r("<h3>".$col.":</h3>");
		#	print_r($row1[$col]."<br>\n\n");
		#}
		
		#######
		echo link_to_book($row['Cultivation details']);
		
		include ('template.php');


		######
		
		
		#$result = safe_query("DESCRIBE `tropicalspecies`");
		#if (!$result) {
		#    echo 'Could not run query: ' . mysql_error();
		#    exit;
		#}
		#if (mysql_num_rows($result) > 0) {
		#    while ($row = mysql_fetch_row($result)) {
		#	$col_name = $row[0];
		#	print_r("<h3>".$col_name.":</h3>");
		#	print_r($row1[$col_name]."<br>\n\n");
		#    }
		#}}
		#echo "</p>";
	}
	
	include 'functions.php';
	include 'dbconnect.php';
	
	if (empty($_GET["id"])) {
		trigger_error("A plant name must be supplied.");
	}
	$key = mysql_real_escape_string($_GET["id"]);
	$redir = null;
	if (! empty($_GET["redir"])) {
		$redir = mysql_real_escape_string($_GET["redir"]);
	}
	#include 'dbconnect.php';
	/*
	SELECT *
	FROM `TropicalSpecies`
	WHERE `Latin name` = 'Abelmoschus moschatus'
	*/

	$result = safe_query("SELECT * FROM `tropicalspecies` WHERE LCASE(`Latin name`) = LCASE('$key')");
	
	//echo "<p>";
	//echo "<table border = \"1\" >";
	//echo "<th>Latin Name</th><th>Commom Name</th><th></th>";

	$row = mysql_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['Latin name']." - Useful Tropical Plants</title>";
		echo "</head>\n<body>";	
		include 'header.php';
			#echo link_to_book($row['Cultivation details']);
		global $redir;
		global $row;
		include('template.php' );
		echo "<script src=\"boxmove.js\"></script>";
		#include('commentsform.php' );
		
		#OutputRecord($row);
	} else {
		echo "<title>".$key."</title>";
		echo "</head>\n<body>";
		include 'header.php';
		$names = array();
		#mysql string comparisons aren't case sensitive, no need to convert case
		$synresult = safe_query('SELECT * FROM `Synonyms`WHERE `LatinName` = "'.$key.'"');
		while ($row = mysql_fetch_assoc($synresult)) {
			$names[] = $row["TrueLatinName"];
		}
		if (count($names) < 1) {
			echo "<p>We have no record for <b>\"".$key."\"</b></p>";
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
?>

</body>
</html>
