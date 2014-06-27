<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">
  <title>Page Not Found - Useful Tropical Plants</title>
</head>
<body>
<?php include 'header.php'; include_once 'functions.php';?>	
	<h1>Page Not Found</h1>
	<p>404 - Page not found, Go <a href="javascript:history.back();">Back</a>
	 or try the <a href="./">Home Page</a>.</p>
<?php 
#emailError("dunno", "404 - Page Not Found.",$_SERVER['REQUEST_URI'],"","");
include 'footer.php' ?>
