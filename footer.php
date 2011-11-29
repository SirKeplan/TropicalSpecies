</div>
<?php
$result = mysql_query("SELECT * FROM `tropicalspecies`"); 
	echo "<p class=\"small\"><b>Last update on 29/11/11:</b> Now containing ".mysql_num_rows($result)." plants.</p>\n	";
	
?>
