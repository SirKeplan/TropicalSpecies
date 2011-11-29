<?php 

/*
$hostname='thefernsherbs.db.6563983.hostedresource.com';
$username='thefernsherbs';
$password='Adhyatma0Herbs';
$dbname='thefernsherbs';
*/

/*
if ($_SERVER["HTTP_HOST"] == "localhost"|| (strpos($_SERVER["HTTP_HOST"],"10.0.0")) !== false) {
	#echo $_SERVER["HTTP_HOST"];
	$hostname='localhost';
	$username='read';
	$password='pagereed';
	$dbname='TropicalSpeciesDB';
} else {
	$hostname='tropicalspecies2.db.6563983.hostedresource.com';
	$username='tropicalreader2';
	$password='Reader001';
	$dbname='tropicalspecies2';
}*/

#$hostname='localhost';
#$username='read';
#$password='pagereed';
#$dbname='TropicalSpeciesDB';

include "dbconnect_local.php";

$db = mysql_connect($hostname, $username,$password);
#$db = mysql_connect('localhost', 'read','pagereed');
if(!$db) {
	die();
}
$selected = mysql_selectdb($dbname, $db);
#$selected = mysql_selectdb("Herbs", $db);
if(!$selected) {
	die();
}
#mb_internal_encoding( 'utf-8' );

mysql_query("SET NAMES 'utf8'");
#mysql_query("SET CHARACTER SET utf8");
#mysql_query("SET CHARACTER_SET_RESULTS=utf8'");


#$sql = "SET NAMES `utf8`";
#mysql_query($sql, $db);
?>
