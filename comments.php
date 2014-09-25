<?php
#this file contains functions for loading comments(or it will) ;)
include_once 'functions.php';

function submit_comment($topic, $user, $user_email, $title, $body) {
	
	
	mysql_query("
		INSERT INTO `TropicalSpeciesDB`.`Comments` (`Topic`, `User`, `UserEmail`, `Title`, `Message`) 
		VALUES ('$topic', '$user', '$user_email', '$title', '$body');");
	echo mysql_error();
}



function output_comments($topic, $curr_page="index.php") {
	
	$result = mysql_query("SELECT * FROM `TropicalSpeciesDB`.`Comments` WHERE Topic = '$topic' LIMIT 0 , 30");
	echo "<div class=\"PageBox\">";
	if (mysql_num_rows($result) > 1) {			
		echo "<h3>Comments</h3>";

		while ($row = mysql_fetch_assoc($result)) {
			echo "<div class=\"comment\">";
			echo "<div class=\"commenttitle\"><strong>".$row['User']."</strong>";
			
			$format = 'Y-m-d H:i:s';
			$date = DateTime::createFromFormat($format, $row['Time']);
			
			echo "<em> ".$date->format('dS F Y G:i')."</em></div>";
			echo "<span class=\"comside\">";
			echo "<div class=\"avatar\">".get_gravatar($row['UserEmail'], 72, 'mm', 'g', true )."</div>";
			#echo "<em>".$row['User']."</em><br>";
			echo "</span>";
			echo "<div class=\"combody\">".$row['Message']."</div>";
			echo "</div>";
		}
	}
	output_comments_form($topic, $curr_page);

	echo "</div>";
	

}/**
 * Get either a Gravatar URL or complete image tag for a specified email address.
 *
 * @param string $email The email address
 * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
 * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
 * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
 * @param boole $img True to return a complete IMG tag False for just the URL
 * @param array $atts Optional, additional key/value attributes to include in the IMG tag
 * @return String containing either just a URL or a complete image tag
 * @source http://gravatar.com/site/implement/images/php/
 */
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
    $url = 'http://www.gravatar.com/avatar/';
    $url .= md5( strtolower( trim( $email ) ) );
    $url .= "?s=$s&d=$d&r=$r";
    if ( $img ) {
        $url = '<img src="' . $url . '"';
        foreach ( $atts as $key => $val )
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function output_comments_form($topic, $curr_page) {
	echo <<<EOT
	
	<h3>Add a Comment:</h3>
	<form class="comments" action="postcomment.php" method="post">
	<input type="hidden" value="$topic" name="topic">
	<input type="hidden" value="$curr_page" name="page">
	<div class="fgroup"><label class="flabel">Name:</label><input name="user" class="fcontrol" type="text"></div>
	<div class="fgroup"><label class="flabel">Email(Private):</label><input name="email" class="fcontrol" type="text"></div>
	<div class="fgroup"><label class="flabel">Body:</label><div class="labeled"><textarea class="farea" name="body" width="800"></textarea></div></div>
	<div class="fgroup"><input type="submit" class="fsubmit" value="Post"></div>
	</form>
EOT;
}

?>
