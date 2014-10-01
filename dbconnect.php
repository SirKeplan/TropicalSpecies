<?php 

include "dbconnect_local.php";

$db = mysqli_connect($hostname, $username, $password, $dbname);
if (mysqli_connect_errno()) {
	trigger_error('Failed to connect to mysqli');
}
#mb_internal_encoding( 'utf-8' );

#safe_query($db, "SET NAMES 'utf8'");
#safe_query($db, "SET CHARACTER SET utf8");
#safe_query($db, "SET CHARACTER_SET_RESULTS=utf8'");
?>
