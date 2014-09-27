<?php
	
	
	include 'comments.php';
	include 'dbconnect.php';

	$body = $_POST["body"];
	$topic = $_POST["topic"];
	$user = $_POST["user"];
	$user_email = $_POST["email"];
	$ques = $_POST["ques"];
	$ans = $_POST["captcha"];
	$title = "";//$_POST["title"];

	$prev_page = $_POST["page"];
	include 'captcha.php';
	if (!is_correct($ques, $ans)) {
		#include 'header.php';
		echo "<strong>Invalid Captcha, are you sure you're a human?</strong>";
		echo '<br>';
		echo '<a href="./" onclick="window.history.back();return false;">Back</a>';
		#include 'footer.php';
		die;
	}
	
	if (!is_valid_email($user_email)) {
		include 'header.php';
		echo "<strong>Invalid email address.</strong>";
		echo '<br>';
		echo '<a href="www.theferns.info" onclick="window.history.back();">Back</a>';
		include 'footer.php';
	}else {

		$id=submit_comment($topic, $user, $user_email, $title, $body);
		
		mysql_close($db);	
		$man_url="http://localhost/theferns/tropical/admin/manage_comment.php";
		
		$to = "admin@theferns.info, ken@theferns.info";
		$subject = "Tropical Database Comment Pending.";
		$message = "$topic:\n\nUserName:\t$user\nEmail:    \t$user_email\n\n$body";
		$message .= "\n\nApprove:\n\t$man_url?op=a&id=$id";
		$message .= "\nDelete:\n\t$man_url?op=d&id=$id";
		mail($to,$subject, $message);
		
		header('Location: '.$prev_page, TRUE, 303);
	}
	
	#echo "<script>window.history.back();</script>";

?>
