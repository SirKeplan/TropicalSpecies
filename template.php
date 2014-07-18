<?php include_once 'functions.php'; ?>
<p>
<div class="leftrightdiv">
	<a id="leftnav" href="viewtropical.php?id=<?php
		$sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` < '{$row['Latin name']}' ORDER BY `Latin name` DESC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo urlencode($row1['Latin name']);?>">
		<img border="0" src="ArrowLeft.png" height="14"  alt="Previous"/>
	</a>
	<a id="rightnav" href="viewtropical.php?id=<?php
		$sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` > '{$row['Latin name']}' ORDER BY `Latin name` ASC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo urlencode($row1['Latin name']);?>">
		<img border="0" src="ArrowRight.png" height="14" alt="Next"/>
	</a>
</div>
<?php 
if ($redir) {
	echo "<p class=\"redir\">(Redirected from <b>$redir</b>)</p>";
}
?>	
<div class="latin_name"><h1><?php echo $row['Latin name']?></h1></div>
<div class="author"><h4><?php echo $row['Author']?></h4></div>
<div class="family"><h4><?php echo $row['Family']?></h4></div>
<?php
if ($row['NomenclatureNotes'] != null) {
	echo "<br>".link_to_book(nl2br($row['NomenclatureNotes']))."<br><br>";
}
?>
<?php 
$full = "123";
echo <<<EOT
	<script type="text/javascript">
function toggle_vis() {
	var ele = document.getElementById('synonyms');
	var val = ele.className;
	var eletext = document.getElementById('syn_text');
	var measure = document.querySelector('#measurement');
	if (val == 'synhid') {
		ele.className = "synshown";
		ele.style.height = measure.clientHeight+'px';
		eletext.innerHTML = "<b>- Synonyms</b>"
	} else {
		ele.className = "synhid";
		ele.style.height = "0";
		eletext.innerHTML = "<b>+ Synonyms</b>"
	}
}
</script>

EOT;
?>
	
	<div><a id="syn_text" onclick="toggle_vis();"><?php if ($full != null) { echo "+"; } else {echo "-";} ?> Synonyms</a></div>
	<div id="synonyms" class="<?php if ($full != null) { echo "synhid"; } else {echo "synshown";} ?>">
	<div id="measurement">
	<?php 
	#output an individual synonym.
	function OutputRecordSyn($row) {
		echo "<p><b><i>{$row["LatinName"]}</i></b> {$row["Author"]}</p>\n";
	}
	$key = $row['Latin name'];

	$result2 = safe_query("SELECT * FROM `Synonyms` WHERE `TrueLatinName` = '$key'");

	while ($row2 = mysql_fetch_assoc($result2)) {
		
		if ($row2) {
			OutputRecordSyn($row2);
		} else {
			echo "<p><b>No record for \"".$key."\"</b></p>";
		}
	}
	mysql_free_result($result2);

?>	
	</div>
	</div>
	
<h4>Common Name: <?php echo $row['Common name']?></h4>
<div class="PBOX">
	<?php
	#loads an array of images for the record
	#each array element is an associative array, containing the image path and other data for the image
	$imgdata = null;
	$imglist = find_images($row['Latin name']);

	if ($imglist) {
		$imgdata = $imglist[0];
	}
	global  $images_path;
	$filename = $images_path.$imgdata["file"];
	if ($imgdata and file_exists($filename)) {
		echo '<a href="image.php?id='.urlencode($row['Latin name']).'"><img class="PIC" src="'.sized_image($filename).'" alt="'.$row['Latin name'].'"/></a>';
		output_image_info($imgdata);

	} else {
		echo '<div class="NOIMAGE">No Image.</div>';
	}
	
	?>

</div>

<h3 class="SHORT">General Information</h3><?php echo link_to_book(nl2br($row['GeneralInformation']))?><br>

<h3 class="SHORT">Known Hazards</h3><?php echo link_to_book(nl2br($row['Known hazards']))?><br>

<h3 class="SHORT">Botanical References</h3><?php echo link_to_book($row['Botanical references'], true)?><br>

<h3>Range</h3><?php echo link_to_book(nl2br($row['Range']))?><br>

<h3>Habitat</h3><?php echo link_to_book(nl2br($row['Habitat']))?><br>

<h3>Properties</h3>
<table class="PROPERTIESTABLE">
<?php 
	#output a table, various "properties" of the plant, 
	#most fields are only output if they contain any data
	$format = "<tr>\n\t<td class=\"PROPERTIESTABLE\">%s</td><td class=\"PROPERTIESTABLE\">%s</td>\n</tr>\t\n";
		
	if ($row['WeedPotential']) {
		$arrayk = array("0", "1");
		$arrayv = array("No", "Yes");
		echo sprintf($format, "Weed Potential", str_replace($arrayk, $arrayv, $row['WeedPotential']));
	}
	if ($row['ConservationStatus'])
	echo sprintf($format, "Conservation Status", $row['ConservationStatus']);
	if ($row['EdibilityRating']) {
		echo sprintf($format, "Edibility Rating", output_bananas($row['EdibilityRating']));
	}
	if ($row['MedicinalRating']) {
		echo sprintf($format, "Medicinal Rating", output_greeny($row['MedicinalRating']));
	}
	if ($row['OtherUsesRating']) {
		echo sprintf($format, "Other Uses Rating", output_other($row['OtherUsesRating']));
	}
	if ($row['Habit']) {
		$DEarray = array("D" => "Deciduous ", "E" => "Evergreen ", "S" => "Semi-deciduous ");
		if(array_key_exists($row['Deciduous/Evergreen'],$DEarray)) {
			echo sprintf($format, "Habit", $DEarray[$row['Deciduous/Evergreen']].$row['Habit']);
		} else {
			echo sprintf($format, "Habit", $row['Habit']);
		}
	}
	if ($row['Height'])
	echo sprintf($format, "Height", $row['Height']." m");
	if ($row['Growth rate']) {
		$arrayk = array("F", "M", "S");
		$arrayv = array("Fast, ", "Medium, ", "Slow, ");
		echo sprintf($format, "Growth Rate", substr(str_replace($arrayk, $arrayv, $row['Growth rate']), 0, -2));
	}
	if ($row['Pollinators'])
	echo sprintf($format, "Pollinators", $row['Pollinators']);
	if ($row['Self-fertile'])
	echo sprintf($format, "Self-fertile", sbool_to_string($row['Self-fertile']));
	if ($row['CultivationStatus']) {
		$arrayk = array("C", "O", "W", "S");
		$arrayv = array("Cultivated, ", "Ornamental, ", "Wild, ", "Semi-cultivated, ");
		echo sprintf($format, "Cultivation Status", substr(str_replace($arrayk, $arrayv, $row['CultivationStatus']), 0, -2));
		
	}
?>
</table>

<h3>Cultivation Details</h3><?php echo link_to_book(nl2br($row['Cultivation details']));?><br>

<h3>Edible Uses</h3><?php echo link_to_book(nl2br($row['Edible uses']))?><br>

<h3>Medicinal</h3><?php echo link_to_book(nl2br($row['Medicinal']))?><br>

<?php
if ($row['AgroforestryUses'] != null) {
	echo "<h3>Agroforestry Uses:</h3>".link_to_book(nl2br($row['AgroforestryUses']))."<br>";
}
?>

<h3>Other Uses</h3><?php echo link_to_book(nl2br($row['Uses notes']))?><br>

<h3>Propagation</h3><?php echo link_to_book(nl2br($row['Propagation 1']))?><br>
