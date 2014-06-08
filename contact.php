<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Contact - Useful Tropical Plants</title>
</head>
<body>
<?php
	include 'header.php';

	echo <<<EOT
	<p>This website and database is regularly updated, please contact us if you find any errors or bugs.</p>
	<p>For queries about the website and online database contact us at: 
	<span id="admin-email"><b>email address hidden with javascript to reduce spamming, enable javascript in your browser to view address</b></span></p>

	<script type="text/javascript">
	<!--

		/*
		any experienced webmasters know if my method actually works at all?
		*/
		var urly = ":otliam".split("").reverse().join("");
		var name = "nimda".split("").reverse().join("");
		var domain= "ofni.snrefeht".split("").reverse().join("");
		var addr = name+"@"+domain;

		document.getElementById("admin-email").innerHTML="<a href=\""+urly+addr+"\">"+addr+"<\/a>";
	-->
	</script>
	
EOT;

	echo <<<EOT
	<p>You can email Ken at: 
	<span id="ken-email"><b>email address hidden with javascript to reduce spamming, enable javascript in your browser to view address</b></span></p>

	<script type="text/javascript">
	<!--

		/*
		any experienced webmasters know if my method actually works at all?
		*/
		var urly = ":otliam".split("").reverse().join("");
		var name = "nek".split("").reverse().join("");
		var domain= "ofni.snrefeht".split("").reverse().join("");
		var addr = name+"@"+domain;

		document.getElementById("ken-email").innerHTML="<a href=\""+urly+addr+"\">"+addr+"<\/a>";
	-->
	</script>
	
EOT;
	
	include 'footer.php';

	mysql_close($db);	
?>
</body>
</html>
