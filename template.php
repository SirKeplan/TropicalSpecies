<?php include_once 'functions.php'; ?>
<p>

<table width="100%" style=''>
	<tr>
		<td style=''><a href="viewtropical.php?id=
		<?php $sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` < '{$row['Latin name']}' ORDER BY `Latin name` DESC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo $row1['Latin name'];?>">Previous</a></td>
		<!--<td style=''><a href="letter-index.php">Index</a></td>-->
		<td align="right" style=''><a href="viewtropical.php?id=
		<?php $sql1 = "SELECT * FROM `tropicalspecies` WHERE `Latin name` > '{$row['Latin name']}' ORDER BY `Latin name` ASC LIMIT 1"; 
		$result1 = safe_query($sql1); 
		$row1 = mysql_fetch_assoc($result1);
		echo $row1['Latin name'];?>">Next</a></td>
	</tr>
</table>

<table style='border-collapse:collapse;
	border:0px;
	padding:0px;
	margin:0px; display: block;'>
	<tr>
		<td style='padding-right:75px;'><h2><?php echo $row['Latin name']?></h2></td>
		<td style='padding-right:75px;'><h4><?php echo $row['Author']?></h4></td>
		<td><h4><?php echo $row['Family']?></h4></td>
	</tr>
</table>
<?php
if ($row['NomenclatureNotes'] != null) {
	echo link_to_book(nl2br($row['NomenclatureNotes']))."<br>";
}
?>
<?php 
$n = $row['Latin name'];
$s = "<a href=\"synonyms.php?id=$n\" onClick=\"RefWindow=window.open('synonyms.php?id=$n','RefWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=610,left=50,top=150'); RefWindow.focus(); return false;\">Synonyms.</a>";
echo $s;#"<a href=\"synonyms.php?id=".$row['Latin name']."\">Show Synonyms.</a>";?>

<h4>Common Name: <?php echo $row['Common name']?></h4>
<div class="PBOX">
	<div class="NOIMAGE">No Image.</div>
	<?php
	$var = $row['Latin name'];
	if (file_exists($var)) {
		echo '<img class="PIC" src="'.$var.'"/>';
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

<<<<<<< HEAD
<h3>Habitat</h3><?php echo link_to_book(nl2br($row['Habitat']))?><br>

<h3>Properties</h3>
=======
<h3>Habitat:</h3><?php echo link_to_book(nl2br($row['Habitat']))?><br>
<!--
<h3>Properties:</h3>
>>>>>>> branch 'master' of https://RichardMorris@github.com/Ajna/TropicalSpecies.git
<table class="PROPERTIESTABLE">

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
		$arrayv = array("D1, ", "M2, ", "We3, ", "Wa4, ");
		echo str_replace($arrayk, $arrayv, $row['Moisture']);
		#echo $row['Habit']
		?>
	</tr>
	
<tr>
		<td class="PROPERTIESTABLE">Well-drained</td><td class="PROPERTIESTABLE"><?php echo bool_to_string($row['Well-drained'])?></td>
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

</table>
<<<<<<< HEAD

<h3>Cultivation Details</h3><?php echo link_to_book(nl2br($row['Cultivation details']));?><br>
=======
-->
<h3>Cultivation Details:</h3><?php echo link_to_book(nl2br($row['Cultivation details']));?><br>
>>>>>>> branch 'master' of https://RichardMorris@github.com/Ajna/TropicalSpecies.git

<h3>Edible Uses</h3><?php echo link_to_book(nl2br($row['Edible uses']))?><br>

<h3>Medicinal</h3><?php echo link_to_book(nl2br($row['Medicinal']))?><br>


<?php
if ($row['AgroforestryUses'] != null) {
	echo "<h3>Agroforestry Uses:</h3><p>".link_to_book(nl2br($row['AgroforestryUses']))."</p>";
}
?>
<!--
<h3>Agroforestry Uses</h3><p><?php echo link_to_book(nl2br($row['AgroforestryUses']))?></p>
-->
<h3>Uses Notes</h3><p><?php echo link_to_book(nl2br($row['Uses notes']))?></p>

<h3>Propagation</h3><p><?php echo link_to_book(nl2br($row['Propagation 1']))?></p>
<!--
<h3>Conservation Status</h3><p><?php echo $row['ConservationStatus']?></p>

<h3>Weed Potential</h3><p><?php echo $row['WeedPotential']?></p>
-->
