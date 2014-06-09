
<?php
include_once 'functions.php';
include_once 'dbconnect.php';

$numPlants = 5500;
$numPlantsRes = safe_query("SELECT count(*) FROM `tropicalspecies`");
$numPlantsRow = mysql_fetch_row($numPlantsRes);
if($numPlantsRow) {
	$numPlants = $numPlantsRow[0];
}

$words = safe_query("SHOW TABLE STATUS LIKE 'tropicalspecies'");
$row = mysql_fetch_row($words);
 $date =  date('Y-m-d', strtotime($row[11]));

echo "</div><div class=\"FOOTER\"><br/><p class=\"small\"><b>Last update on {$date}:</b> Now containing $numPlants plants.</p>\n";


?>
<p class="small">
<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">
	<img alt="Creative Commons License" class="cclicense" src="http://i.creativecommons.org/l/by-nc-sa/3.0/88x31.png" />
</a>
<span prefix="dct: http://purl.org/dc/terms/ cc: http://creativecommons.org/ns#" href="http://purl.org/dc/dcmitype/Dataset" property="dct:title" rel="dct:type">Tropical Species Database</span> 2012 by 
	<a href="http://tropical.theferns.info/" property="cc:attributionName" rel="cc:attributionURL">Ken Fern</a>, 
	web interface by 
	<a href="http://ajna.theferns.info/" property="cc:attributionName" rel="cc:attributionURL">Ajna Fern</a>
	with help from 
	<a href="http://singsurf.org/" property="cc:attributionName" rel="cc:attributionURL">Richard Morris</a>.
	<br />   
	The database and code is licensed under a 
	<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.
</p>
</div>
