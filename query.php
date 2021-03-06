<!DOCTYPE html>
<html>
<head>
<title>Search - Useful Tropical Plants</title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
<link rel=stylesheet href="style.css" type="text/css">  
<link rel="shortcut icon" href="flower.ico">
</head>
<body>
  <script type="text/javascript">
	window.onload = function () {
		var ele = document.getElementById('options');
		var val = ele.className;
		if (val == 'synhid') {
			ele.style.height = "0";
		}else {
			//not proud of the following code, i added it on a timer because of odd FF mobile behaviour
			//atleast it can't kill anything if it goes wrong.
			setTimeout(function(){ele.style.height = measure.clientHeight+'px';},500)
			//ele.style.height = measure.clientHeight+'px';
		}
	}	
function toggle_vis() {
	var ele = document.getElementById('options');
	var val = ele.className;
	var eletext = document.getElementById('adv_text');
	var measure = document.querySelector('#measure');
	if (val == 'synhid') {
		ele.className = "synshown";
		ele.style.height = measure.clientHeight+'px';
		eletext.innerHTML = "<b>- Advanced search</b>"
	} else {
		ele.className = "synhid";
		ele.style.height = "0";
		eletext.innerHTML = "<b>+ Advanced search</b>"
	}
}
  </script>
<?php

	include 'functions.php';
	include 'dbconnect.php';
	include 'header.php';

	mb_regex_encoding("UTF-8");
	
	//Um, what was this for?
	if(empty($_GET["common"])) {
		$common = "";
	}
	else {
		$common = $_GET["common"];
		if(preg_match('/^[\w ]+$/',$common)!=1) {
			trigger_error("Invalid common name: \"".htmlspecialchars($common)."\", must only have letters.");
		}
	}
	//$full is the fulltext search string, whatever the user entered in the search box
	if(empty($_GET["full"])) {
		$full = ""; 
		if(isset($_GET["full"])) {
			echo "<h2>Empty search string given</h2>\n";
			echo "</body></html>\n";
			die;
		}
	}
	else {
		$full = $_GET["full"];
		if(mb_ereg('^[\wÁáäãçéèêëíłñóôöüý× ]+$',$full)!=1) {
			//trigger_error("Invalid search term: \"".htmlspecialchars($full)."\", must only contain letters.");
			echo "<h2>Search string contains invalid characters</h2>\n
					<p>try removing any non alphanumeric characters</p>\n";
			echo "</body></html>\n";
			die;
		}
	}
	//whether to order by best result or alphabetically	
	if(empty($_GET["show"])) {
		$orderbest = true;
	} else {	
		//set to false only if show = alpha
		$orderbest = !($_GET["show"] == "alpha");
	}
	//echo "<h1>Tropical Database</h1>\n";
	$full = mysqli_real_escape_string($db, $full);

	//where there any arguments passed to the page
	$anything = (strlen($_SERVER['QUERY_STRING']) > 1);

	//Shows advanced search if user didnt send a simple fulltext query
	$adv_search_shown = ($full == null);
	
	//Shows advanced search if they didn't send anything as a query;
	$adv_search_shown = ($anything);
	//echo "<p>Latin '$full' common '$common'.</p>\n";
?>
	<h2>Database Search</h2>

	<p>
	<!--<form method="get" action="query.php">
		<div>Full text search: <input type="text" name="full" value="<?php echo $full?>" />
		<input type="submit" value="GO" /></div>
	</form>
	-->

	<div><a id="adv_text" onclick="toggle_vis();"><?php if ($adv_search_shown) { echo "+"; } else {echo "-";} ?> Advanced search</a></div>
	
	<div id="options" class="<?php if ($adv_search_shown) { echo "synhid"; } else {echo "synshown";} ?>">
	<div id="measure">
	<p>Use this form to search all plants by fields you select, selecting less options will return more plants.<br/>
	Note: currently a lot of this information is incomplete and some fields will return few results.<br/>
	Fields marked with * have incomplete information</p>
	<form id="QueryForm" method="get" action="query.php">
	<div class="miniBorder">
	<table id="QUERYTABLE" class="tableBase1 tableQuery">
		<tr>
			<td class="TITLE"><b>Habit</b></td>
			<td><select multiple="multiple" name="Habit" size="5">
				<option value="Annual">Annual</option>
				<option value="Annual Climber">Annual Climber</option>
				<option value="Annual/Biennial">Annual/Biennial</option>
				<option value="Annual/Perennial">Annual/Perennial</option>
				<option value="Bamboo">Bamboo</option>
				<option value="Biennial">Biennial</option>
				<option value="Bulb">Bulb</option>
				<option value="Climber">Climber</option>
				<option value="Corm">Corm</option>
				<option value="Fern">Fern</option>
				<option value="Perennial">Perennial</option>
				<option value="Perennial Climber">Perennial Climber</option>
				<option value="Shrub">Shrub</option>
				<option value="Tree">Tree</option>
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
		</tr>	
		<tr>
			<td class="TITLE"><b>Growth Rate</b></td>
			<td><input type="checkbox" name="Growth rate" value="F"/>Fast
			<input type="checkbox" name="Growth rate" value="M"/>Medium
			<input type="checkbox" name="Growth rate" value="S"/>Slow</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Soil *</b></td>
			<td><input type="checkbox" name="Soil" value="L"/>Light
			<input type="checkbox" name="Soil" value="M"/>Medium
			<input type="checkbox" name="Soil" value="H"/>Heavy</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Heavy Clay *</b></td>
			<td><input type="checkbox" name="Heavy clay" value="0"/>No
			<input type="checkbox" name="Heavy clay" value="1"/>Yes</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Poor Soil *</b></td>
			<td><input type="checkbox" name="Poor soil" value="0"/>No
			<input type="checkbox" name="Poor soil" value="1"/>Yes</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Nitrogen Fixer</b></td>
			<td><input type="checkbox" name="Nitrogen fixer" value="0"/>No
			<input type="checkbox" name="Nitrogen fixer" value="1"/>Yes</td>
		</tr>
		<tr>
			<td class="TITLE"><b>PH *</b></td>
			<td><input type="checkbox" name="pH" value="A"/>Acid
			<input type="checkbox" name="pH" value="N"/>Neutral
			<input type="checkbox" name="pH" value="B"/>Base</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Acid *</b></td>
			<td><input type="checkbox" name="Acid" value="0"/>No
			<input type="checkbox" name="Acid" value="1"/>Yes
		</tr>
		<tr>
			<td class="TITLE"><b>Alkaline *</b></td>
			<td><input type="checkbox" name="Alkaline" value="0"/>No
			<input type="checkbox" name="Alkaline" value="1"/>Yes
		</tr>
		<tr>
			<td class="TITLE"><b>Saline *</b></td>
			<td><input type="checkbox" name="Saline" value="0"/>No
			<input type="checkbox" name="Saline" value="1"/>Yes
		</tr>
		<tr>
			<td class="TITLE"><b>Shade *</b></td>
			<td><input type="checkbox" name="Shade" value="F"/>Full
			<input type="checkbox" name="Shade" value="S"/>Semi
			<input type="checkbox" name="Shade" value="N"/>None</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Moisture *</b></td>
			<td><input type="checkbox" name="Moisture" value="D"/>Dry
			<input type="checkbox" name="Moisture" value="M"/>Moist
			<input type="checkbox" name="Moisture" value="We"/>Wet or Boggy
			<input type="checkbox" name="Moisture" value="Wa"/>Water</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Well Drained *</b></td>
			<td><input type="checkbox" name="Drainage" value="1"/>Yes
			<input type="checkbox" name="Drainage" value="0"/>No</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Tolerates Drought *</b></td>
			<td><input type="checkbox" name="Drought" value="1"/>Yes
			<input type="checkbox" name="Drought" value="0"/>No</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Wind *</b></td>
			<td><input type="checkbox" name="Wind" value="W"/>Light
			<input type="checkbox" name="Wind" value="M"/>Medium</td>
		</tr>
		<tr>
			<td class="TITLE"><b>Tolerates Pollution *</b></td>
			<td><input type="checkbox" name="Pollution" value="Y"/>Yes
			<input type="checkbox" name="Pollution" value="N"/>No</td>
		</tr><tr>
			<td><input type="submit" value="Search" /></td>
			
		</tr>
	</table>
	</div>
	</form>
	</div>
	</div>
	
<?php
	//still needs some improvement doesnt it
	$fullsql = "*".$full."*";
    $string = 
    "SELECT *,
		CASE when `Latin name` like \"$full\" then 1 else 0 END as latinmatch, 
		CASE when `Common name` like \"$full\" then 1 else 0 END as commonmatch,

		MATCH(Author,NomenclatureNotes,`Known hazards`,`Range`,`Habitat`,`GeneralInformation`,
		`Cultivation details`,`Edible uses`,`Medicinal`,`AgroforestryUses`,`Uses notes`,`Propagation 1`,`Names`) 
		AGAINST (\"$fullsql\") AS score
	FROM tropicalspecies
    WHERE MATCH(Author,NomenclatureNotes,`Known hazards`,`Range`,`Habitat`,`GeneralInformation`,
        `Cultivation details`,`Edible uses`,`Medicinal`,`AgroforestryUses`,`Uses notes`,`Propagation 1`,`Names`) 
        AGAINST (\"$fullsql\" IN BOOLEAN MODE)"; //
    
	//	echo htmlspecialchars(urldecode($_SERVER['QUERY_STRING']));

	/*a query field search was asked for*/
    if ($full == null && $anything ) {
		$query = explode('&', $_SERVER['QUERY_STRING']);
		
		$params = array();
		global $params;
		foreach( $query as $param )
		{
			if (empty($param)) {
				continue;
			}
			list($name, $value) = explode('=', $param);
			$params[urldecode($name)][] = urldecode($value);
		}

		//print_r($params);
		$string = "SELECT `Latin name`,`Common name` FROM tropicalspecies WHERE ";
		$add = "";	
		$end = false;//var to end when found page numbers in _GET being passed in
		$parts = array();
		
		$allowedKeys = array("Habit","Deciduous/Evergreen","Height","Width","Hardyness","Growth rate",
			"Soil","Heavy clay","Poor soil","Nitrogen fixer","pH","Acid","Alkaline","Saline",
			"Shade","Moisture","Drainage","Drought","Wind","Pollution","amount","pageno");

		
		foreach ($params as $key => $val) {
			
			// Check if the key is allowed
			if(!in_array($key,$allowedKeys)) {
				trigger_error("Invalid key \"".htmlspecialchars($key)."\"");
			}
				
			$booladded = false;
			$first = true;
			foreach ($val as $key2 => $individual) {
			
				// check if the value is allowed
				if(preg_match('/^[\w -\/]*$/',$individual)!=1) {
					trigger_error('Invalid value "'.htmlspecialchars($individual).'"');
				}
				if ($key == "pageno" OR $key == "amount") {
					//echo "yada";
					$end = true;
					break;//to catch page numbers in _GET being passed in
				}
				$op = "=";
				if ($key == "Height" OR $key == "Width") {
					$op = " BETWEEN ";
					if(preg_match('/^([\.\d]+)-([\.\d]+)$/',$individual,$matches)==1) {
						$individual = $matches[1] . "' AND '" . $matches[2];
						//echo "HeightWidth: ". htmlspecialchars($individual);
					} else {
						trigger_error("Illegal value for $key '$val'");
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
			$add = $add."') AND ";
		}
		$string = $string.$add."TRUE";
	}
	
	/*a text search was asked for*/
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
		
		//for passing on to other pages to keep same results
		$http_query = $_GET;
		
		//for getting totla record count
		$all = safe_query($db, $string);

		$result = null;
		if ($orderbest) {
			if ($full) {
				$result = safe_query($db, $string." ORDER BY latinmatch DESC, commonmatch DESC, score DESC LIMIT $pageno, $amount"); 
			}else {
				$result = safe_query($db, $string." LIMIT $pageno, $amount"); 
			}
		}else {
			$result = safe_query($db, $string." ORDER BY `Latin name` ASC LIMIT $pageno, $amount"); 
		}

		$allcount = mysqli_num_rows($all);
				
		if($full) {
			echo "<form action=\"query.php\" method=\"get\"><input type=\"hidden\" name=\"full\" value=\"$full\"><p>".mysqli_num_rows($all)." records";
			#echo " found for <b>\"$full\"</b>".($orderbest? " Showing best results first.":" Showing alphabetically.")."";
			echo " found for <b>\"$full\"</b> Showing records ";
			echo "<select name=\"show\" onchange=\"this.form.submit()\">
			<option value=\"best\" ".($orderbest?"selected":"").">Best First</option>
			<option value=\"alpha\" ".($orderbest?"":"selected").">Alphabetically</option>
			</select></p></form>";
		}else{
			echo "<p>".mysqli_num_rows($all)." records";
			echo ".</p>";
		}
		
		$http_query["amount"] = $amount;

		//nav controls
		nav_controls("query.php", $http_query, $pageno, $amount, $allcount);
		
		//echo "<a href=query.php?".http_build_query($http_query).">Next page</a> ";
		output_table_query_limited($result, "Nothing", "tropicalspecies",null, "Latin name", "viewtropical.php", "id", -1, array("Latin name", "Common name"));
		//nav controls
		nav_controls("query.php", $http_query, $pageno, $amount, $allcount);
		
	}

	include 'footer.php';

	mysqli_close($db);
?>
	
<script type="text/javascript">

	form = document.getElementById('QueryForm');
	<?php
	
	global $params;

	if ($params) {
		foreach ($params as $key => $val) {
			foreach ($val as $inkey) {
				#if ($key == "Height" OR $key == "Width") {
				#	continue;
				#}
				echo <<<EOT
	
	var control = form.elements["$key"];
	for (var no = 0; no < control.length; no++) {
		if (control[no].value == "$inkey") {
			if (control[no] instanceof HTMLOptionElement ) {
				control[no].selected = true;
			} else {
				control[no].checked = true;
			}
		}
	}

EOT;
				
			}
		}
	}
	?>

</script>
</body>

</html>
