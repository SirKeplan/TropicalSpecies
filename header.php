<script type="text/javascript">
function togglePrompt (box, focus) {
    box = document.getElementById("searchbox");
    box.value = (focus?"":box.defaultValue);
    if (focus) {
		box.style.cssText = "font-style: normal;color: black;";
	}else {
		box.style.cssText = "font-style: italic;color: grey;";
	}
}
</script>
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
	// timestamp for the error entry
	//$dt = date("Y-m-d H:i:s (T)");
	die("PHP error: $errmsg");
}
$old_error_handler = set_error_handler("userErrorHandler");

	include 'dbconnect.php';
	include 'functions.php';
?>
<div class="HEADERBLOCK">
<a class="HOME" href="index.php">Tropical Species Database</a>
<?php
	//echo '</div>';
	//$result = mysql_query("SELECT * FROM `tropicalspecies`"); 
	//echo "<p><b>Last update on 26/06/11:</b> Now containing ".mysql_num_rows($result)." plants.</p>\n	";
	//echo "<p><a href=\"query.php\">Search</a></p>";
?>
	
<ul class="NAVBAR CURVEBOTH" >
	<li class="NAVBARLI CURVELEFT">
		<a class="NAVBARITEM CURVELEFT" href="./">Home</a>
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
	</li><li class="SEARCH"><form action="query.php" method="get"><div><input type="text" id="searchbox" name="full"  
    value="Search:" onfocus="togglePrompt(this.searchbox, true)" 
    alt="Search" onblur="togglePrompt(this.searchbox, false)" ></div></form>
</li>
</ul>
</div>
<div class="CONTENT">

