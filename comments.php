<?php
#this file contains functions for loading comments(or it will) ;)
include 'functions.php';
	
	$hostname = "localhost";
$username = "comments";
$dbname = "TropicalSpeciesDB";
$password='yRuDtmejPEFqSRwP';

$db = mysql_connect($hostname,$username,$password);
if(!$db) {
	trigger_error('Failed to connect to mysql');
}
$selected = mysql_selectdb($dbname, $db);
if(!$selected) {
	trigger_error("Failed to select database");
}
	
##output_comments("testpage1");

function submit_comment($topic, $user, $user_email, $title, $body) {
	
	
	mysql_query("
		INSERT INTO `TropicalSpeciesDB`.`Comments` (`Topic`, `User`, `UserEmail`, `Title`, `Message`) 
		VALUES ('$topic', '$user', '$user_email', '$title', '$body');");
	echo mysql_error();
}



function output_comments($topic) {

	output_comments_form();
	
	$result = mysql_query("SELECT * FROM `TropicalSpeciesDB`.`Comments` LIMIT 0 , 30");
	
	while ($row = mysql_fetch_assoc($result)) {
		echo "<h4>".$row['Title']."</h4>";
		echo "<em>".$row['User']."</em><br>";
		echo $row['Message']."<br>";
	}

}
function output_comments_form() {
	echo <<<EOT
	
	<h3>Add a Comment:</h3>
	<form class="comments" action="postcomment.php" method="post">
	<input type="hidden" value="testtopic" name="topic">
	<div class="fgroup"><label class="flabel">Name:</label><input name="user" class="fcontrol" type="text"></input></div>
	<div class="fgroup"><label class="flabel">Email(Private):</label><input name="user_email" class="fcontrol" type="text"></input></div>
	<div class="fgroup"><label class="flabel">Title:</label><input name="title" class="fcontrol" type="text"></input></div>
	<div class="fgroup"><label class="flabel">Body:</label><textarea class="farea" name="body" width="800"></textarea></div>
	<div class="fgroup"><input type="submit" class="fsubmit" value="Post"></div>
	</form>
EOT;
}

?>
