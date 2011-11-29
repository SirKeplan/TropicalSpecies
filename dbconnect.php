<?php 

include "dbconnect_local.php";

$db = mysql_connect($hostname,$username,$password);
if(!$db) {
	die('Failed to connect to mysql');
}
$selected = mysql_selectdb($dbname, $db);
if(!$selected) {
	die("Failed to select database");
}
#mb_internal_encoding( 'utf-8' );

mysql_query("SET NAMES 'utf8'");
#mysql_query("SET CHARACTER SET utf8");
#mysql_query("SET CHARACTER_SET_RESULTS=utf8'");
?>
