<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">

<?php
	function link_to_book($string) {
		$regex = '/(?<=\[|,\s)(\d*)(?=,\s|\])/';

		preg_match_all($regex, $string, $matches);

		$rep = array();
		$pat = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$pat[$i] = $regex;#"/{$matches[$i]}/";
			$rep[$i] = '<a href="bookref.php?id=$1">$1</a>';
		}
		$newstring = preg_replace($pat, $rep, $string, -1, $count);
                  
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
		#echo link_to_book($row['Cultivation details']);
		
		#include ('template.php');


		######
		
		
		$result = safe_query("DESCRIBE `References`");
		if (!$result) {
		    echo 'Could not run query: ' . mysql_error();
		    exit;
		}
		if (mysql_num_rows($result) > 0) {
		    while ($row1 = mysql_fetch_row($result)) {
				$col_name = $row1[0];
				print_r("<h3>".$col_name.":</h3>");
				if ($col_name == "Href") {
					print_r("<a target=\"_blank\" href=\"".$row[$col_name]."\">".$row[$col_name]."</a><br>\n\n");
				} else {
					print_r(link_to_book($row[$col_name])."<br>\n\n");
				}
		    }
		}
		#echo "</p>";
	}
	
	include_once 'functions.php';
	include 'dbconnect.php';

	if (empty($_GET["id"])) {
		trigger_error("A book ID should be specified");
		return;
	}
	$key = mysql_real_escape_string($_GET["id"]);
	
	if ($key == "K") {
		echo "<title>".$row['Title']."</title>";
		echo "</head>\n<body>";	
		OutputRecord( array("No" => "K", "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips."));

		mysql_close($db);
		return;
	}
	#include 'dbconnect.php';
	/*
	SELECT *
	FROM `TropicalSpecies`
	WHERE `Latin name` = 'Abelmoschus moschatus'
	*/

	$result = safe_query("SELECT * FROM `References` WHERE `No` = $key");
	
	//echo "<p>";
	//echo "<table border = \"1\" >";
	//echo "<th>Latin Name</th><th>Commom Name</th><th></th>";

	$row = mysql_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['Title']."</title>";
		echo "</head>\n<body>";	
			#echo link_to_book($row['Cultivation details']);
		#global $row;
		#include('template.php' );
		OutputRecord($row);
	} else {
		echo "<title>".$key."</title>";
		echo "</head>\n<body>";
		//include 'header.php';
		echo "<p><b>No record for \"".$key."\"</b></p>";
		
	}
	mysql_free_result($result);

	mysql_close($db);
?>

</body>
</html>
