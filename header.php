<script type="text/javascript">
/** show or hide the search bos(for small screens) */
function showHideSearch() {
	var disp = document.getElementById("SEARCH").style.display;
	if (disp == "block") {
		disp = "";//the default specified in css file
	}else {
		disp = "block";
	}	
	document.getElementById("SEARCH").style.display = disp;
	document.getElementById("searchbox").focus();
}
/** Makes search box show prompt text when not focused */
function togglePrompt (box, focus) {
    if (box.value != box.defaultValue && box.value != "") {
		return;
	}
    box.value = (focus?"":box.defaultValue);
    if (focus) {
		box.style.cssText = "font-style: normal;color: black;";
	}else {
		box.style.cssText = "font-style: italic;color: grey;";
	}
}
</script>
<div class="HEADERBLOCK">
<a class="HOME" href="index.php">Useful Tropical Plants</a>
<div class="NAVDIV">
<ul class="NAVBAR" >
	<li class="NAVBARLI">
		<a class="NAVBARITEM" href="./">Home</a>
	</li>
	<li class="NAVBARLI">
		<a class="NAVBARITEM" href="query.php">Search</a>
	</li>
	<li class="NAVBARLI">
		<a class="NAVBARITEM" href="contact.php">Contact</a>
	</li>
	<!--<li class="NAVBARLI">
		<a class="NAVBARITEM" href="about.php">About</a>
	</li> -->
	<li class="SEARCHBUTTON" id="SEARCHBUTTON">
		<a onclick="showHideSearch()"><img src="searchicon.png" height="25" alt="Show Search"/></a>
	</li>
	<li class="SEARCH" id="SEARCH">
		<form action="query.php" method="get">
			<div>
				<input type="text" class="searchbox" id="searchbox" name="full"  
				value="Search:" onfocus="togglePrompt(searchbox, true)" 
				onblur="togglePrompt(searchbox, false)" >
			</div>
		</form>
	</li>
</ul>
</div>
</div>

<div class="CONTENT">
