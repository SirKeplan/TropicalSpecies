<?php

?>
<!DOCTYPE html>
<html>

<head>
	<title>untitled</title>
	<link rel=stylesheet href="style.css" type="text/css">  
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
<script src="autocomplete_box.js">
</script>
</head>

<body>
	<p></p>
	<form class="searchform" name="searchform">
		<input type="search" Value="poo" id="boo" name="boo" autocomplete="off">
		<div id="searchResults" class="autoCompleteList" style="display:none;"></div>
		<script>
			var handler = new AutoCompleteBox("boo", "searchResults");
			//attachEvents("boo", "searchResults");
		</script>
		<p id="out">Layout stuffs...</p>
	</form>
</body>

</html>
