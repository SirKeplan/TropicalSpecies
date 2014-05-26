<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Tropical Species Database About</title>
</head>
<body>
<?php
	include 'header.php';
	echo <<<EOT
	<p>the history of pfaf, and ken, the website, and the database, maybe, or maybe just the database.
	</p>
EOT;
	include 'footer.php';

	mysql_close($db);	

?>

</body>
</html>
