<script type="text/javascript">
function togglePrompt (box, focus) {
    //	document.write(box);
    //box = document.getElementById("searchbox");
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
<a class="HOME" href="index.php">Tropical Species Database</a>
	
<ul class="NAVBAR" >
	<li class="NAVBARLI">
		<a class="NAVBARITEM" href="./">Home</a>
	</li><li class="NAVBARLI">
		<a class="NAVBARITEM" href="common-index.php">Common Names</a>
	</li><li class="NAVBARLI">
	</li><li class="NAVBARLI">
		<a class="NAVBARITEM" href="letter-index.php">Latin Names</a>
	</li><li class="NAVBARLI">
	</li><li class="NAVBARLI">
		<a class="NAVBARITEM" href="query.php">Search</a>
	</li><li class="NAVBARLI">
		<a class="NAVBARITEM" href="contact.php">Contact</a>
	</li><li class="NAVBARLI">
		<a class="NAVBARITEM" href="about.php">About</a>
	</li><li class="SEARCH"><form action="about.php" method="get"><div><input type="text" class="searchbox" id="searchbox" name="full"  
    value="Search:" onfocus="togglePrompt(searchbox, true)" 
    alt="Search" onblur="togglePrompt(searchbox, false)" ></div></form>
</li>
</ul>
</div>

<div class="CONTENT">
