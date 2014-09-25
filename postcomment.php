<?php
	
	
	include 'comments.php';
	include 'dbconnect.php';

	$body = $_POST["body"];
	$topic = $_POST["topic"];
	$user = $_POST["user"];
	$user_email = $_POST["email"];
	$title = "";//$_POST["title"];

	$prev_page = $_POST["page"];
	
	if (!is_valid_email($user_email)) {
		include 'header.php';
		echo "<strong>Invalid email address.</strong>";
		echo '<br>';
		echo '<a href="www.theferns.info" onclick="window.history.back();">Back</a>';
		include 'footer.php';
	}else {

		submit_comment($topic, $user, $user_email, $title, $body);
		mysql_close($db);	
		header('Location: '.$prev_page, TRUE, 303);
	}
	
	#echo "<script>window.history.back();</script>";

?>
