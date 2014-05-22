<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Tropical Species Database Contact</title>
</head>
<body>
<?php
	include 'header.php';
	//include 'dbconnect.php';
	//include '../medicinal/functions.php';
	//echo "<h1>Tropical Database</h1>\n";
	
	/*
	$result = safe_query("SELECT * FROM `tropicalspecies`"); 
	echo "<p><b>Last update on 04/03/11:</b> Now containing ".mysql_num_rows($result)." plants.</p>\n	";
	echo "<p><a href=\"query.php\">Search</a></p>";
	*/
	//04/03/11  4580
	//02/02/11  4292
	//26/12/10	4117
	//echo "<p><b>Revision 3:</b> Now containing ".mysql_num_rows($result)." plants.<br>\n	";
	//echo "<b>Revision 2:</b> Contained 3940 plants.<br>\n	";
	//echo "<b>Revision 1:</b> Contained 3681 plants.<br>\n	";
	//echo "Original Contained 3552 plants.</p>";	
	echo <<<EOT
	<p>For queries about the website and online database contact us at: <span id="admin-email"><b>email address hidden with javascript to reduce spamming, enable javascript in your browser to view address</b></span></p>

	<script type="text/javascript">
	<!--

		/*
		any experienced webmasters kow if my method actually works at all?
		*/
		var urly = ":otliam".split("").reverse().join("");
		var name = "nimda".split("").reverse().join("");
		var domain= "ofni.snrefeht".split("").reverse().join("");
		var addr = name+"@"+domain;

		document.getElementById("admin-email").innerHTML="<a href=\""+urly+addr+"\">"+addr+"<\/a>";
	-->
	</script>
	</p>
EOT;

	echo <<<EOT
	<p>You can email ken at: <span id="ken-email"><b>email address hidden with javascript to reduce spamming, enable javascript in your browser to view address</b></span></p>

	<script type="text/javascript">
	<!--

		/*
		any experienced webmasters kow if my method actually works at all?
		*/
		var urly = ":otliam".split("").reverse().join("");
		var name = "nek".split("").reverse().join("");
		var domain= "ofni.snrefeht".split("").reverse().join("");
		var addr = name+"@"+domain;

		document.getElementById("ken-email").innerHTML="<a href=\""+urly+addr+"\">"+addr+"<\/a>";
	-->
	</script>
	</p>
EOT;
	
	include 'footer.php';

	mysql_close($db);	

?>

</body>
</html>
