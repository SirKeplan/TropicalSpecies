<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8">
<link rel=stylesheet href="style.css" type="text/css">

<?php
	
	
	include 'comments.php';
	include 'dbconnect.php';

	$body = $_POST["body"];
	$topic = $_POST["topic"];
	$user = $_POST["user"];
	$user_email = $_POST["email"];
	$title = "";//$_POST["title"];

	$prev_page = $_POST["page"];

	submit_comment($topic, $user, $user_email, $title, $body);
	header('Location: '.$prev_page, TRUE, 303);

	echo "<script>window.history.back();</script>";

?>
</div>
</body>
</html>
