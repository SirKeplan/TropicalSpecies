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
	<form class="searchform">
		<input type="search" Value="poo" id="boo" autocomplete="off" onfocus="togglePrompt(boo, true)" onblur="togglePrompt(boo, false)" 
		onkeydown="return selectItem(event, boo);" onkeyup="getResults(event, this, this.value)">
<!--	<select id="searchResults" style="display:none;" size="6" onmousedown="doSomething(event, boo)" oninput="selected(event, boo, searchResults)"></select>
-->
	<div id="searchResults" onmousedown="doSomething(event, boo)" oninput="selected(event, boo, searchResults)"></div>

	<p>Layout stuffs...</p></form>
</body>

</html>
