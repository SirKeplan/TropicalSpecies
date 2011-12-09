<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Tropical Species Database Search</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel=stylesheet href="style.css" type="text/css">
</head>

<body>
	<script type="text/javascript">
function toggle_vis() {
	var val = document.getElementById('options').style.display;
	if (val == 'none') {
		document.getElementById('options').style.display = 'block';
		document.getElementById('adv_text').innerHTML = "- Advanced"

	} else {
		document.getElementById('options').style.display = 'none';
		document.getElementById('adv_text').innerHTML = "+ Advanced"

	}
}
</script>
	
<?php

	include 'functions.php';
	include 'dbconnect.php';
	include 'header.php';

	if(empty($_GET["common"])) {
		$common = "";
	}
	else {
		$common = $_GET["common"];
		if(preg_match('/^[\w ]+$/',$common)!=1) {
			trigger_error("Invalid common name: \"".htmlspecialchars($common)."\", must only have letters.");
		}
	}
	if(empty($_GET["full"])) {
		$full = "";
	}
	else {
		$full = $_GET["full"];
		if(preg_match('/^[\w ]+$/',$full)!=1) {
			trigger_error("Invalid botanical name: \"".htmlspecialchars($full)."\", must only have letters.");
		}
	}

	//echo "<h1>Tropical Database</h1>\n";
	$full = mysql_real_escape_string($full);

	//echo "<p>Latin '$full' common '$common'.</p>\n";
?>
	<form method="get" action="query.php">
		<div>Full text search: <input type="text" name="full" value="<?php echo $full?>" />
		<input type="submit" value="GO" /></div>
	</form>

	<div><a id="adv_text" onclick="toggle_vis();"><?php if ($full != null) { echo "+"; } else {echo "-";} ?> Advanced</a></div>
	<div id="options" style="<?php if ($full != null) { echo "display:none"; } else {echo "display:block";} ?>">
	<p>Use the form below to search all plants by fields you select, selecting less options will return more plants.<br/> Note: currently a lot of this information is incomplete and some fields will return few results.</p>
	<form method="get" action="query.php">
	<table id="QUERYTABLE">
		<tr>
			<td class="TITLE"><b>Habit</b></td>
			<td><select multiple="multiple" name="Habit" size="5">
				<option>Annual</option>
				<option>Annual Climber</option>
				<option>Annual/Biennial</option>
				<option>Annual/Perennial</option>
				<option>Bamboo</option>
				<option>Biennial</option>
				<option>Bulb</option>
				<option>Climber</option>
				<option>Corm</option>
				<option>Fern</option>
				<option>Perennial</option>
				<option>Perennial Climber</option>
				<option>Shrub</option>
				<option>Tree</option>
			</select>
		

		</tr>
		<tr>
			<td class="TITLE"><b>Decid/Evergreen</b></td>
			<td><input type="checkbox" name="Deciduous/Evergreen" value="D"/>Deciduous
			<input type="checkbox" name="Deciduous/Evergreen" value="E"/>Evergreen
			<input type="checkbox" name="Deciduous/Evergreen" value="S"/>Semi Deciduous</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Height</b></td>
			<td><select name="Height">
				<option value="0-999">All</option>
				<option value="0-0.1">0-10cm</option>
				<option value="0.1-1">10cm-1m</option>
				<option value="1-4">1m-4m</option>
				<option value="4-10">4m-10m</option>
				<option value="10-20">10m-20m</option>
				<option value="20-40">20m-40m</option>
				<option value="40-60">40m-60m</option>
				<option value="60-100">60m-100m</option>
			</select></td>

 			<!--
			<td colspan="3"><input type="checkbox" name="Height" value="0' AND '0.1"/>0-10cm
			<input type="checkbox" name="Height" value="0' AND '1"/>10cm-1m
			<input type="checkbox" name="Height" value="1' AND '4"/>1m-4m
			<input type="checkbox" name="Height" value="4' AND '10"/>4m-10m
			<input type="checkbox" name="Height" value="10' AND '20"/>10m-20m
			<input type="checkbox" name="Height" value="20' AND '40"/>20m-40m
			<input type="checkbox" name="Height" value="40' AND '60"/>40m-60m
			<input type="checkbox" name="Height" value="60' AND '100"/>60m-100m</td>-->
 		</tr>
		<tr>
			<td class="TITLE"><b>Width</b></td>
			<td><select name="Width">
				<option value="0-999">All</option>
				<option value="0-1">0-1m</option>
				<option value="1-4">1m-4m</option>
				<option value="4-10">4m-10m</option>
				<option value="10-20">10m-20m</option>
				<option value="20-50">20m-50m</option>
			</select></td>

 			<!--
			<td><input type="checkbox" name="Width" value="0' AND '1"/>1</td>
			<td><input type="checkbox" name="Width" value="1' AND '4"/>1-4</td>
			<td><input type="checkbox" name="Width" value="4' AND '10"/>4-10</td>
			<td><input type="checkbox" name="Width" value="10' AND '20"/>10-20</td>
			<td><input type="checkbox" name="Width" value="20' AND '50"/>20-50</td>-->
		</tr>		
		<tr>
			<td class="TITLE"><b>Hardyness</b></td>
			<td 	><input type="checkbox" name="Hardyness" value="1"/>1
			<input type="checkbox" name="Hardyness" value="2"/>2
			<input type="checkbox" name="Hardyness" value="3"/>3
			<input type="checkbox" name="Hardyness" value="4"/>4
			<input type="checkbox" name="Hardyness" value="5"/>5
			<input type="checkbox" name="Hardyness" value="6"/>6
			<input type="checkbox" name="Hardyness" value="7"/>7
			<input type="checkbox" name="Hardyness" value="8"/>8
			<input type="checkbox" name="Hardyness" value="9"/>9
			<input type="checkbox" name="Hardyness" value="10"/>10
			<input type="checkbox" name="Hardyness" value="11"/>11
			<input type="checkbox" name="Hardyness" value="12"/>12</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Growth Rate</b></td>
			<td><input type="checkbox" name="Growth rate" value="F"/>Fast
			<input type="checkbox" name="Growth rate" value="M"/>Medium
			<input type="checkbox" name="Growth rate" value="S"/>Slow</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Soil</b></td>
			<td><input type="checkbox" name="Soil" value="L"/>Light
			<input type="checkbox" name="Soil" value="M"/>Medium
			<input type="checkbox" name="Soil" value="H"/>Heavy</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Heavy Clay</b></td>
			<td><input type="checkbox" name="Heavy clay" value="0"/>No
			<input type="checkbox" name="Heavy clay" value="1"/>Yes</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Poor Soil</b></td>
			<td><input type="checkbox" name="Poor soil" value="0"/>No
			<input type="checkbox" name="Poor soil" value="1"/>Yes</td>
			

		</tr>
		<tr>
			<td class="TITLE"><b>Nitrogen Fixer</b></td>
			<td><input type="checkbox" name="Nitrogen fixer" value="0"/>No
			<input type="checkbox" name="Nitrogen fixer" value="1"/>Yes</td>
		</tr>
		<tr>
			<td class="TITLE"><b>PH</b></td>
			<td><input type="checkbox" name="pH" value="A"/>Acid
			<input type="checkbox" name="pH" value="N"/>Neutral
			<input type="checkbox" name="pH" value="B"/>Base</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Shade</b></td>
			<td><input type="checkbox" name="Shade" value="F"/>Full
			<input type="checkbox" name="Shade" value="S"/>Semi
			<input type="checkbox" name="Shade" value="N"/>None</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Moisture</b></td>
			<td><input type="checkbox" name="Moisture" value="D"/>Dry
			<input type="checkbox" name="Moisture" value="M"/>Moist
			<input type="checkbox" name="Moisture" value="We"/>Wet or Boggy
			<input type="checkbox" name="Moisture" value="Wa"/>Water</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Well Drained</b></td>
			<td><input type="checkbox" name="Well-drained" value="1"/>Yes
			<input type="checkbox" name="Well-drained" value="0"/>No</td>
		</tr>
		
		<tr>
			<td class="TITLE"><b>Tolerates Drought</b></td>
			<td><input type="checkbox" name="Drought" value="1"/>Yes
			<input type="checkbox" name="Drought" value="0"/>No</td>
						

		</tr>
		<tr>
			<td class="TITLE"><b>Wind</b></td>
			<td><input type="checkbox" name="Wind" value="W"/>Light
			<input type="checkbox" name="Wind" value="M"/>Medium</td>
						<td></td>

		</tr>
		<tr>
			<td class="TITLE"><b>Tolerates Pollution</b></td>
			<td><input type="checkbox" name="Pollution" value="Y"/>Yes
			<input type="checkbox" name="Pollution" value="N"/>No</td>

		</tr><tr>
			<td><input type="submit" value="Search" /></td>
			
		</tr>
	</table>
	</form>
	

	</div>
<?php
    //$result = search($common, "tropicalspecies", array("Common name"));
    $string = 
    "SELECT *,
		MATCH(Author,NomenclatureNotes,`Known hazards`,`Range`,`Habitat`,`GeneralInformation`,
		`Cultivation details`,`Edible uses`,`Medicinal`,`AgroforestryUses`,`Uses notes`,`Propagation 1`,`Names`) 
		AGAINST (\"$full\") AS score
	FROM tropicalspecies
    WHERE MATCH(Author,NomenclatureNotes,`Known hazards`,`Range`,`Habitat`,`GeneralInformation`,
        `Cultivation details`,`Edible uses`,`Medicinal`,`AgroforestryUses`,`Uses notes`,`Propagation 1`,`Names`) 
        AGAINST (\"$full\")"; // IN BOOLEAN MODE
    $anything = (strlen($_SERVER['QUERY_STRING']) > 1);
    if ($full == null) {
		$query  = explode('&', $_SERVER['QUERY_STRING']);

		//echo htmlspecialchars(urldecode($_SERVER['QUERY_STRING']));
		$params = array();
		foreach( $query as $param )
		{
		  list($name, $value) = explode('=', $param);
		  $params[urldecode($name)][] = urldecode($value);
		}
		//print_r($params);
		$string = "SELECT `Latin name`,`Common name` FROM tropicalspecies WHERE ";
		$add = "";	
		$end = false;//var to end when found page numbers in _GET being passed in
		$parts = array();
		foreach ($params as $key => $val) {
			//echo "<p>Key $key Val ".var_export($val)."</p>";
			$booladded = false;
			$first = true;
			foreach ($val as $key2 => $individual) {
			//echo "<p>Key2 $key2 individual $individual</p>";
				if ($key == "pageno" OR $key == "amount") {
					//echo "yada";
					$end = true;
					break;//to catch page numbers in _GET being passed in
				}
				$op = "=";
				if ($key == "Height" OR $key == "Width") {
					$op = " BETWEEN ";
					if(preg_match('/^(\d+)-(\d+)$/',$individual,$matches)==1) {
						$individual = $matches[1] . "' AND '" . $matches[2];
						//echo "HeightWidth: ". htmlspecialchars($individual);
					} else {
						trigger_error("Illgal value for $key '$val'");
					}
				}
				#echo $individual.$key2;
				if ( $first) {
					$add = $add."(";
				}
				if ($key2 < count($val)-1) {
					
					$add = $add."`$key`$op'".$individual."' OR ";
					#$booladded = true;
				}else {
					#if ( $first) {
					#	$add = $add."(";
					#}
					$add = $add."`$key`$op'".$individual;
				}
				$first = false;
			}
			if ($end) {
				break;// you get it
			}
			##if ($booladded) {
				$add = $add."') AND ";
			##} else {
			##	$add = $add."' AND ";
			##}

		}
		//if ($anything) {
			$string = $string.$add."TRUE";
			//$string = "SELECT * FROM tropicalspecies WHERE `Growth rate`='".implode("' OR `Growth rate`='", $params["growth_rate"])."'";
			//echo '<pre>';
			//echo htmlspecialchars(print_r($params, true));
			//echo '</pre>';
			//echo $string;
		//}
	}
    if ($anything == true) {
	
		$pageno = empty($_GET["pageno"]) ? 0 : $_GET["pageno"];
		if(preg_match('/^\d+$/',$pageno)!=1) {
			trigger_error("Invalid pageno: \"".htmlspecialchars($pageno)."\", must be a number.");
		}
		$amount = empty($_GET["amount"]) ? 100 : $_GET["amount"];
		if(preg_match('/^\d+$/',$amount)!=1) {
			trigger_error("Invalid amount: \"".htmlspecialchars($amount)."\", must be a number.");
		}
		//echo htmlspecialchars(urldecode($string));
		
		$http_query = $_GET;
		$all = safe_query($string); 
		$result = safe_query($string." LIMIT $pageno, $amount"); 
		$allcount = mysql_num_rows($all);
		
		echo "<p>".mysql_num_rows($all)." records.</p>";
		
		
		$http_query["amount"] = $amount;

		//nav controls
		nav_controls("query.php", $http_query, $pageno, $amount, $allcount);
		
		//echo "<a href=query.php?".http_build_query($http_query).">Next page</a> ";
		output_table_query_limited($result, "Nothing", "tropicalspecies",null, "Latin name", "viewtropical.php", "id", -1, array("Latin name", "Common name"));

	}

	include 'footer.php';

	mysql_close($db);
?>
</body>
</html>
