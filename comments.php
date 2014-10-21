<?php
#this file contains functions for loading comments(or it will) ;)
include_once 'functions.php';
function submit_comment($topic, $user, $user_email, $title, $body) {
	global $db;
	
	$statement = mysqli_prepare($db, "INSERT INTO `Comments` (`Topic`, `User`, `UserEmail`, `Title`, `Message`) VALUES (?, ?, ?, ?, ?);");

	mysqli_stmt_bind_param($statement, 'sssss', $topic, $user, $user_email, $title, $body);

	if (!mysqli_stmt_execute($statement)) {
		echo "Execute failed: (" . $statement->errno . ") " . $statement->error;
	}
	mysqli_stmt_close($statement);	
	
	return mysqli_insert_id($db);
}

function output_comments($topic, $curr_page="index.php") {
	global $db;
	
	$result = safe_query($db, "SELECT * FROM `Comments` WHERE Topic = '$topic' AND Approved = 1 LIMIT 0 , 30");
	$str = sha1($topic.$_SERVER["REMOTE_ADDR"]);
	if (isset($_COOKIE[$str])) {
		$id = $_COOKIE[$str];
		$result = safe_query($db, "SELECT * FROM `Comments` WHERE (`Topic` LIKE '$topic' AND `Approved` =1 ) OR `ID` =$id LIMIT 0 , 30");
	}
	if (mysqli_num_rows($result) > 0) {			
		echo "</div>";
		echo "<div class=\"PageBox\">";
		echo "<h3>Comments</h3>";

		while ($row = mysqli_fetch_assoc($result)) {
			echo "<div class=\"comment\" id=\"com${row['ID']}\">";
			echo "<div class=\"commenttitle\"><strong>".$row['User']."</strong>";
			
			$format = 'Y-m-d H:i:s';
			$date = DateTime::createFromFormat($format, $row['Time']);
			
			echo "<em> ".$date->format('dS F Y G:i')."</em></div>";
			echo "<span class=\"comside\">";
			echo "<div class=\"avatar\">".get_gravatar($row['UserEmail'], 72, 'mm', 'g', true )."</div>";
			#echo "<em>".$row['User']."</em><br>";
			echo "</span>";
			if ($row['Approved']) {
				echo "<div class=\"combody\">".nl2br($row['Message'])."</div>";
			}else {
				echo "<div class=\"combody grey\">".'<strong><em class="black">Awaiting Moderation.</em></strong><br><br>'.nl2br($row['Message'])."</div>";
			}
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
	include 'captcha.php';
	$ques = array_rand($questions);
	$ans = $questions[array_rand($questions)];
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
	<h3 id="comment">Add a Comment:</h3>
	<p>If you have any useful information about this plant, please leave a comment. Comments have to be approved before they are shown here.</p>
	<form name="comments" class="comments" action="postcomment.php" onsubmit="return validate_form();" method="post">
	<input type="hidden" value="$topic" name="topic">
	<input type="hidden" value="$curr_page" name="page">
	<input type="hidden" value="$ques" name="ques">
	<div class="fgroup"><label class="flabel">Name:</label><div class="labeled"><input name="user" class="fcontrol" type="text"></div></div>
	<div class="fgroup"><label class="flabel">Email(Private):</label><div class="labeled"><input name="email" class="fcontrol" type="email"></div></div>
	<div class="fgroup"><label class="flabel">Message:</label><div class="labeled"><textarea class="farea" name="body" rows="6"></textarea></div></div>
	<div class="fgroup"><label class="flabel" for="captcha"><strong>Captcha: </strong>$ques</label><input class="fcontrol short" type="text" name="captcha" id="captcha"></div>
	<div class="fgroup"><input type="submit" class="fsubmit" value="Submit"></div>
	</form>
EOT;
}

?>
