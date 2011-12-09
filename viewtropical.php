<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <link rel=stylesheet href="style.css" type="text/css">

<?php
	function link_to_book($string, $other = false) {
		if ($other){			
			$regex = '/(?<=^|,\s)(\d*)/';
		}else {
			$regex = '/(?<=\[|,\s)(\d*|K)(?=,\s|\])/';
		}
		preg_match_all($regex, $string, $matches);

		$rep = array();
		$pat = array();
		for ($i = 0; $i < count($matches[1]); $i++) {
			$pat[$i] = $regex;#"/{$matches[$i]}/";
			$rep[$i] = '<a href="bookref.php?id=$1" onClick="RefWindow=window.open(\'bookref.php?id=$1\',\'RefWindow\',\'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=610,left=50,top=150\'); RefWindow.focus(); return false;">$1</a>';
			##
			
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
		echo link_to_book($row['Cultivation details']);
		
		include ('template.php');


		######
		
		
		#$result = mysql_query("DESCRIBE `tropicalspecies`");
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
	
	$key = mysql_real_escape_string($_GET["id"]);
	if ($key == "") {
		trigger_error("A plant name must be supplied.");
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
		echo "<title>".$row['Latin name']."</title>";
		echo "</head>\n<body>";	
		include 'header.php';
			#echo link_to_book($row['Cultivation details']);
		global $row;
		include('template.php' );
		#include('commentsform.php' );
		
		#OutputRecord($row);
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
