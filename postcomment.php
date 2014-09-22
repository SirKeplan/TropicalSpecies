<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel=stylesheet href="style.css" type="text/css">

<?php
	
	
	include 'comments.php';
	
	$body = $_POST["body"];
	$topic = $_POST["topic"];
	$user = $_POST["user"];
	$user_email = $_POST["user_email"];
	$title = $_POST["title"];

	submit_comment($topic, $user, $user_email, $title, $body);
	echo "hi";

?>
</div>
</body>
</html>
