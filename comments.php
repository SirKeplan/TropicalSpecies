<?php
#this file contains functions for loading comments(or it will) ;)
include_once 'functions.php';

function submit_comment($topic, $user, $user_email, $title, $body) {
	
	$body = mysql_real_escape_string($body);
	safe_query("
		INSERT INTO `TropicalSpeciesDB`.`Comments` (`Topic`, `User`, `UserEmail`, `Title`, `Message`) 
		VALUES ('$topic', '$user', '$user_email', '$title', '$body');");
	return mysql_insert_id();
}



function output_comments($topic, $curr_page="index.php") {
	
	$result = mysql_query("SELECT * FROM `TropicalSpeciesDB`.`Comments` WHERE Topic = '$topic' AND Approved = 1 LIMIT 0 , 30");
	if (mysql_num_rows($result) > 0) {			
		echo "</div>";
		echo "<div class=\"PageBox\">";
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
	echo "</div>";
	echo "<div class=\"PageBox\">";
	
	output_comments_form($topic, $curr_page);

	

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
	<script>
	
	function validate_form() {
		var user = document.forms["comments"]["user"].value;
		var email = document.forms["comments"]["email"].value;
		var body = document.forms["comments"]["body"].value;
		
		if (user == "" || user == null) {
			alert ("You must fill in all the fields when leaving a comment");
			return false;
		}
		if (email == "" || email == null) {
			alert ("You must fill in all the fields when leaving a comment");
			return false;
		}
		if (body == "" || body == null) {
			alert ("You must fill in all the fields when leaving a comment");
			return false;
		}
		var atpos = email.indexOf("@");
		var dotpos = email.lastIndexOf(".");
		if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=email.length) {
			alert("You have to enter a real email address.\\nsorry about that.");
			return false;
		}
		
		if (body.length < 8) {
			alert ("Please give a meaningful comment :-( ");
			return false;
		}
		return true;
	}
	
	</script>
	<h3>Add a Comment:</h3>
	<form name="comments" class="comments" action="postcomment.php" onsubmit="return validate_form();" method="post">
	<label class="flabel" for="captcha">do be continued</label><input type="check" name="captcha">
	<input type="hidden" value="$topic" name="topic">
	<input type="hidden" value="$curr_page" name="page">
	<div class="fgroup"><label class="flabel">Name:</label><input name="user" class="fcontrol" type="text"></div>
	<div class="fgroup"><label class="flabel">Email(Private):</label><input name="email" class="fcontrol" type="email"></div>
	<div class="fgroup"><label class="flabel">Message:</label><div class="labeled"><textarea class="farea" name="body" width="800"></textarea></div></div>
	<div class="fgroup"><input type="submit" class="fsubmit" value="Submit"></div>
	</form>
EOT;
}

?>
