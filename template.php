<?php include_once 'functions.php'; ?>
<p>

<table width="100%" style=''>
	<tr>
		<td style=''><a href="viewtropical.php?id=
		<?php $sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` < '{$row['Latin name']}' ORDER BY `Latin name` DESC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo $row1['Latin name'];?>"><img img border="0" src="ArrowLeft.png" height="14"  alt="Previous"/></a></td>
		<!--<td style=''><a href="letter-index.php">Index</a></td>-->
		<td align="right" style=''><a href="viewtropical.php?id=
		<?php $sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` > '{$row['Latin name']}' ORDER BY `Latin name` ASC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo $row1['Latin name'];?>"><img img border="0" src="ArrowRight.png" height="14" alt="Next"/></a></td>
	</tr>
</table>

<div class="latin_name"><h2><?php echo $row['Latin name']?></h2></div>
<div class="author"><h4><?php echo $row['Author']?></h4></div>
<div class="family"><h4><?php echo $row['Family']?></h4></div>
<?php
if ($row['NomenclatureNotes'] != null) {
	echo link_to_book(nl2br($row['NomenclatureNotes']))."<br><br>";
}
?>
<?php 
$n = $row['Latin name'];
$s = "<a href=\"synonyms.php?id=$n\" onClick=\"RefWindow=window.open('synonyms.php?id=$n','RefWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=610,left=50,top=150'); RefWindow.focus(); return false;\">Synonyms.</a>";

#echo $s;#"<a href=\"synonyms.php?id=".$row['Latin name']."\">Show Synonyms.</a>";#

$full = "123";
echo <<<EOT
	<script type="text/javascript">
function toggle_vis() {
	var val = document.getElementById('synonyms').style.display;
	if (val == 'none') {
		document.getElementById('synonyms').style.display = 'block';
		document.getElementById('syn_text').innerHTML = "<b>- Synonyms</b>"

	} else {
		document.getElementById('synonyms').style.display = 'none';
		document.getElementById('syn_text').innerHTML = "<b>+ Synonyms</b>"

	}
}
</script>

EOT;
?>
	
	<div><a id="syn_text" onclick="toggle_vis();"><b><?php if ($full != null) { echo "+"; } else {echo "-";} ?> Synonyms</b></a></div>
	<div id="synonyms" style="<?php if ($full != null) { echo "display:none"; } else {echo "display:block";} ?>">
	<?php 

	function OutputRecordSyn($row) {
		echo "<p><b><i>{$row["LatinName"]}</i></b> {$row["Author"]}</p>\n";
	}
	$key = $n;

	$result2 = safe_query("SELECT * FROM `Synonyms` WHERE `TrueLatinName` = '$key'");

	#echo "<h2>Synonyms for $key</h2>\n";

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
	
	
<h4>Common Name: <?php echo $row['Common name']?></h4>
<div class="PBOX">
	<?php
	$imgdir = "plantimages/";
	$var1 = $imgdir.$row['Latin name'].".png";
	$var2 = $imgdir.$row['Latin name'].".jpg";
	if (file_exists($var1)) {
		//echo <<<EOT
		//<span class="NOIMAGE">Image Loading.</span>
//EOT;
		echo '<img class="PIC" src="'.$var1.'"/>';
	} else {
		if (file_exists($var2)) {
			//echo <<<EOT
			//<span class="NOIMAGE">Image Loading.</span>
	//EOT;
			echo '<img class="PIC" src="'.$var2.'"/>';
		} else {
		echo <<<EOT
		<div class="NOIMAGE">No Image.</div>
EOT;
		}
	}
	?>
</div>


<h3 class="SHORT">General Information</h3><?php echo link_to_book(nl2br($row['GeneralInformation']))?><br>

<h3 class="SHORT">Known Hazards</h3><?php echo link_to_book(nl2br($row['Known hazards']))?><br>
<h3 class="SHORT">Botanical References</h3><?php echo link_to_book($row['Botanical references'], true)?><br>
<!--<?php
if ($row['NomenclatureNotes'] != null) {
	echo "<h3 class=\"SHORT\">Nomenclature Notes:</h3>".link_to_book(nl2br($row['NomenclatureNotes']))."<br>";
}
?>-->
<!--
<h3 class="SHORT">Nomenclature Notes:</h3><?php echo $row['NomenclatureNotes']?><br>
-->
<h3>Range</h3><?php echo link_to_book(nl2br($row['Range']))?><br>


<h3>Habitat</h3><?php echo link_to_book(nl2br($row['Habitat']))?><br>

<h3>Properties</h3>
<table class="PROPERTIESTABLE">
<?php 
	$format = "<tr>\n\t<td class=\"PROPERTIESTABLE\">%s</td><td class=\"PROPERTIESTABLE\">%s</td>\n</tr>\t\n";

		
	if ($row['WeedPotential'])
	echo sprintf($format, "Weed Potential", $row['WeedPotential']);
	if ($row['ConservationStatus'])
	echo sprintf($format, "Conservation Status", $row['ConservationStatus']);
	if ($row['EdibilityRating'])
	echo sprintf($format, "Edibility Rating", $row['EdibilityRating']);
	if ($row['MedicinalRating'])
	echo sprintf($format, "Medicinal Rating", $row['MedicinalRating']);
	if ($row['OtherUsesRating'])
	echo sprintf($format, "Other Uses Rating", $row['OtherUsesRating']);
	if ($row['Habit'])
		$DEarray = array("D" => "Deciduous ", "E" => "Evergreen ", "S" => "Semi-deciduous ");
		if(array_key_exists($row['Deciduous/Evergreen'],$DEarray)) {
			echo sprintf($format, "Habit", $DEarray[$row['Deciduous/Evergreen']].$row['Habit']);
		} else {
			echo sprintf($format, "Habit", $row['Habit']);
		}
	if ($row['Height'])
	echo sprintf($format, "Height", $row['Height']);
	if ($row['Growth rate'])
	echo sprintf($format, "Growth Rate", $row['Growth rate']);
	if ($row['Pollinators'])
	echo sprintf($format, "Pollinators", $row['Pollinators']);
	if ($row['Self-fertile'])
	echo sprintf($format, "Self-fertile", $row['Self-fertile']);
	if ($row['CultivationStatus']) {
		$arrayk = array("C", "O", "W", "S");
		$arrayv = array("Cultivated, ", "Ornamental, ", "Wild, ", "Semi-cultivated, ");
		echo sprintf($format, "Cultivation Status", substr(str_replace($arrayk, $arrayv, $row['CultivationStatus']), 0, -2));
		
	}
?>
<!--
<tr>
	<td class="PROPERTIESTABLE">Hardyness</td><td class="PROPERTIESTABLE"><?php echo $row['Hardyness']?></td>
</tr>

<tr>
	<td class="PROPERTIESTABLE">Weed Potential</td><td class="PROPERTIESTABLE"><?php echo $row['WeedPotential']?></td>
</tr>	
<tr>
	<td class="PROPERTIESTABLE">Conservation Status</td><td class="PROPERTIESTABLE"><?php echo $row['ConservationStatus']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Edibility Rating</td><td class="PROPERTIESTABLE"><?php echo $row['EdibilityRating']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Medicinal Rating</td><td class="PROPERTIESTABLE"><?php echo $row['MedicinalRating']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Other Uses Rating</td><td class="PROPERTIESTABLE"><?php echo $row['OtherUsesRating']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Habit</td><td class="PROPERTIESTABLE">
		<?php 
		$DEarray = array("D" => "Deciduous ", "E" => "Evergreen ", "S" => "Semi-deciduous ");
		//echo "<p>".$row['Deciduous/Evergreen']." ". $row['Habit']."</p>\n";
		if(array_key_exists($row['Deciduous/Evergreen'],$DEarray)) 
			echo $DEarray[$row['Deciduous/Evergreen']];
		echo $row['Habit'] ;
		#echo $row['Habit']
		?>	
	</td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Height</td><td class="PROPERTIESTABLE"><?php echo $row['Height']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Width</td><td class="PROPERTIESTABLE"><?php echo $row['Width']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Growth Rate</td><td class="PROPERTIESTABLE"><?php echo $row['Growth rate']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Soil</td><td class="PROPERTIESTABLE"><?php 
		$Sarray = array("L" => "Light", "M" => "Medium", "H" => "Heavy", "LM" => "Light, Medium", "MH" => "Medium, Heavy", "LMH" => "Light, Medium, Heavy");
		if(array_key_exists($row['Soil'],$Sarray))
		echo $Sarray[$row['Soil']];
		#echo $row['Habit']
		?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Heavy Clay</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Heavy clay'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Poor Soil</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Poor soil'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Nitrogen Fixer</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Nitrogen fixer'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">pH</td><td class="PROPERTIESTABLE"><?php 
		$arrayk = array("A", "N", "B");
		$arrayv = array("Acid, ", "Neutral, ", "Alkaline, ");
		echo str_replace($arrayk, $arrayv, $row['pH']);
		#echo $row['Habit']
		?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Acid</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Acid'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Alkaline</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Alkaline'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Saline</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Saline'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Moisture</td><td class="PROPERTIESTABLE"><?php 
	$arrayk = array("D", "M", "We", "Wa");
	$arrayv = array("Dry, ", "Moist, ", "Wet, ", "Water, ");
	echo str_replace($arrayk, $arrayv, $row['Moisture']);
	#echo $row['Habit']
	?>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Well-drained</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Drainage'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Drought</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Drought'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Shade</td><td class="PROPERTIESTABLE"><?php 
	$arrayk = array("F", "S", "N");
	$arrayv = array("Full, ", "Semi, ", "None");
	echo str_replace($arrayk, $arrayv, $row['Shade']);
	#echo $row['Habit']
	?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Wind</td><td class="PROPERTIESTABLE"><?php echo $row['Wind']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Pollution</td><td class="PROPERTIESTABLE"><?php echo sbool_to_string($row['Pollution'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Flower Type</td><td class="PROPERTIESTABLE"><?php 
	$arrayk = array("H", "M", "D");
	$arrayv = array("Hermaphrodite", "Monoecious", "Dioecious");
	echo str_replace($arrayk, $arrayv, $row['Flower Type']);
	#echo $row['Habit']
	?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Pollinators</td><td class="PROPERTIESTABLE"><?php echo $row['Pollinators']?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Self-fertile</td><td class="PROPERTIESTABLE"><?php echo sbool_to_string($row['Self-fertile'])?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">CultivationStatus</td><td class="PROPERTIESTABLE"><?php 
	$arrayk = array("C", "O", "W", "S");
	$arrayv = array("Cultivated, ", "Ornamental, ", "Wild, ", "Semi-cultivated, ");
	echo str_replace($arrayk, $arrayv, $row['CultivationStatus']);
	#echo $row['Habit']
	?></td>
</tr>
<tr>
	<td class="PROPERTIESTABLE">Scented</td><td><?php echo bool_to_string($row['Scented'])?></td>
</tr>
-->
</table>

<h3>Cultivation Details</h3><?php echo link_to_book(nl2br($row['Cultivation details']));?><br>

<h3>Edible Uses</h3><?php echo link_to_book(nl2br($row['Edible uses']))?><br>

<h3>Medicinal</h3><?php echo link_to_book(nl2br($row['Medicinal']))?><br>



<?php
if ($row['AgroforestryUses'] != null) {
	echo "<h3>Agroforestry Uses:</h3>".link_to_book(nl2br($row['AgroforestryUses']))."<br>";
}
?>
<!--
<h3>Agroforestry Uses</h3><p><?php echo link_to_book(nl2br($row['AgroforestryUses']))?></p>
-->
<h3>Uses Notes</h3><?php echo link_to_book(nl2br($row['Uses notes']))?><br>

<h3>Propagation</h3><?php echo link_to_book(nl2br($row['Propagation 1']))?><br>
<!--
<h3>Conservation Status</h3><p><?php echo $row['ConservationStatus']?></p>

<h3>Weed Potential</h3><p><?php echo $row['WeedPotential']?></p>
-->
