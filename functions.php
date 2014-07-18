<?php
// Set up error reporting to catch all errors
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
//error_reporting(E_ERROR);
error_reporting(E_ALL ^ E_DEPRECATED);
// Error handeler for reporting errors
function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars)
{
	if (!(error_reporting() & $errno)) {
		// This error code is not included in error_reporting
		return;
    }
    include_once "header.php";
	
	echo "<h1>Sorry an error occured</h1>\n<p>line $linenum: $errmsg</p>\n";
	echo "</body></html>\n";
		
	emailError($errno, $errmsg, $filename, $linenum, $vars);
	die;
}
$old_error_handler = set_error_handler("userErrorHandler");
function emailError($errno, $errmsg, $filename, $linenum, $vars) {
	// timestamp for the error entry
	$dt = date("Y-m-d H:i:s (T)");
	
	ob_start();
	var_dump($vars);
	$dump = ob_get_clean();
	
	$admin = "admin@theferns.info";
	$subject = "Tropical Database Error.";
	$message = "$dt\nError code: $errno in file $filename\n
	line $linenum: $errmsg\n
	From user ${_SERVER["REMOTE_ADDR"]} - ${_SERVER["HTTP_USER_AGENT"]} \n
	Vars: $dump";
	if (mail($admin,$subject, $message)) {
		#echo("<p>Message successfully sent!</p>");
	} else {
		#echo("<p>Message delivery failed...</p>");
	}

}

$images_path = "plantimages/";

// wrap a mysql query in code to test for sucessful query
function safe_query($query)
{
	$res = mysql_query($query);
	if(!$res) {
		//print "<h2>Sorry an Error Occured</h2>\n";
		$err = mysql_error();
		$err =  "MySQL error. Query: " . htmlspecialchars($query);
		trigger_error($err);
		exit;
	}
	return $res;
}

function usefull($input, $arraykeys, $arraydata) {
	#$output = "";
	return str_replace($arraykeys, $arraydata, $input);
}

function transcode($input, $array) {
	return $array[$input];
}

function bool_to_string($val) {
	if ($val == 0) {
		return "No";
	} else if ($val == 1) {
		return "Yes";
	} else {
		return "N/A";
	}
}

function sbool_to_string($val) {
	if ($val == "N") {
		return "No";
	} else if ($val == "Y"){
		return "Yes";
	} else {
		return "N/A";
	}
}

function field($row, $col, $col_name) {
	$data = nl2br($row[$col]);
	if ($data == "") {
		$data = "None known";
	}
	return "<h3>$col_name:</h3>\n
		<p>".$data."</p>\n";
}

function get_col_names($col, $table, $relation, $ignore = array("ID","Dis")) {
	$result_cols = safe_query("DESCRIBE `$table`");
	if (!$result_cols) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	if (mysql_num_rows($result_cols) <= 0) {
		return;
	}

	//$result = safe_query("SELECT * FROM `$table` WHERE `$col` = '$relation'");
	//echo "<table border = \"1\" >\n";

	// put the column names into an array
	$columns = array();
	$index = 0;
	while ($row2 = mysql_fetch_row($result_cols)) {
		//echo $ignore;
		if ($row2[0] == $col || in_array($row2[0], $ignore)) {
			continue;
		}
		$columns[$index] = $row2[0];
		//echo ("<th>".$row2[0]."</th>");
		$index ++;
	}
	return $columns;
}

// my nice function
function output_table($col, $table, $relation, $linkwith = null, $linkto = null, $getfield = null, $ignore = array("ID","Dis")) {
	$relation = mysql_real_escape_string($relation);
	$sql = "SELECT * FROM `$table` WHERE `$col` = '$relation' ORDER BY `$table`.`$linkwith` ASC";
	#echo $sql;
	output_table_sql($sql, $col, $table, $relation, $linkwith, $linkto, $getfield, -1, $ignore);
}

function output_table_sql($sql, $col, $table, $relation, $linkwith = null, $linkto = null, $getfield = null, $trim = -1, $ignore = array("ID","Dis")) {
	$result = safe_query($sql);
	output_table_query($result, $col, $table, $relation, $linkwith, $linkto, $getfield, $trim, $ignore);
}

// my nice function
function output_table_query($query, $col, $table, $relation, $linkwith = null, $linkto = null, $getfield = null, $trim = -1, $ignore = array("ID","Dis"), $fnames = null) {
	//include_once "functions.php";
	/*$result_cols = safe_query("DESCRIBE `$table`");
		if (!$result_cols) {
	echo 'Could not run query: ' . mysql_error();
	exit;
	}
	if (mysql_num_rows($result_cols) <= 0) {
	return;
	}
	*/
	$columns = get_col_names($col, $table, $relation, $ignore);

	$result = $query;//safe_query($sql);
		
	echo "<table class=\"RECORDTABLE\" >\n";
	echo "<tr>";
	foreach ($columns as $row2) {
		$col_name = ($fnames == null ? $row2 : $fnames[$row2]);
		if ($linkwith != null && $linkwith == $row2) {
			echo ("<th class=\"ANCHORH\">".$col_name."</th>");
		} else {
			echo ("<th>".$col_name."</th>");
		}
	}
	echo "</tr>\n";
	/*
		// put the column names into an array
	$columns = array();
	$index = 0;
	while ($row2 = mysql_fetch_row($result_cols)) {

	if ($row2[0] == $col || in_array($row2[0], $ignore)) {
	continue;
	}
	$columns[$index] = $row2[0];
	echo ("<th>".$row2[0]."</th>");
	$index ++;
	}
	*/
	echo "\n";
	//echo "<th>Food</th><th>Notes</th>";


	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr class="RECORDTABLE">';
		foreach ($columns as $row2) {
			//print_r($row2[0].", ");
			//echo "<td class=\"DISEASE\">";
			//echo "<a href = \"viewrecord.php?disease=".$row["Disease"]."\">".$row["Disease"]."</a>";
			//echo "</td>\n";

			//echo "<td class=\"".strtoupper($row2)."\">";
			if ($linkwith != null && $linkwith == $row2) {
				echo "<td class=\"ANCHOR\">";
				echo "<a href = \"$linkto?$getfield=".$row[$row2]."\">".$row[$row2]."</a>";
			} else {
				echo "<td class=\"NORMAL\">";
				if ($trim == -1) {
					echo $row[$row2];
				} else {
					echo shorten($row[$row2], $trim);
				}
			}
			echo "</td>\n";
			/*echo "<td class=\"NOTES\" >";
				echo $row["Notes"];
			echo "</td>";*/
		}
		echo "</tr>\n";
	}
	mysql_free_result($result);
	echo "</table>\n";
}

function output_table_query_limited($query, $col, $table, $relation, $linkwith = null, $linkto = null, $getfield = null, $trim = -1, $names = array(), $linkfrom = null) {
	//include_once "functions.php";
	/*$result_cols = safe_query("DESCRIBE `$table`");
		if (!$result_cols) {
	echo 'Could not run query: ' . mysql_error();
	exit;
	}
	if (mysql_num_rows($result_cols) <= 0) {
	return;
	}
	*/
	$columns = $names;//get_col_names($col, $table, $relation, $ignore);

	$result = $query;//safe_query($sql);
		
	echo "<table class=\"RECORDTABLE\" >\n";
	echo "<tr>";
	foreach ($columns as $row2) {
		if ($linkwith != null && $linkwith == $row2) {
			echo ("<th class=\"ANCHORH\">".$row2."</th>");
		} else {
			echo ("<th>".$row2."</th>");
		}
	}
	echo "</tr>\n";
	/*
		// put the column names into an array
	$columns = array();
	$index = 0;
	while ($row2 = mysql_fetch_row($result_cols)) {

	if ($row2[0] == $col || in_array($row2[0], $ignore)) {
	continue;
	}
	$columns[$index] = $row2[0];
	echo ("<th>".$row2[0]."</th>");
	$index ++;
	}
	*/
	echo "\n";
	//echo "<th>Food</th><th>Notes</th>";

	if ($linkfrom != null) {
		#$linkwith = $linkfrom;
	}
	while ($row = mysql_fetch_assoc($result)) {
		echo '<tr class="RECORDTABLE">';
		foreach ($columns as $row2) {
			//print_r($row2[0].", ");
			//echo "<td class=\"DISEASE\">";
			//echo "<a href = \"viewrecord.php?disease=".$row["Disease"]."\">".$row["Disease"]."</a>";
			//echo "</td>\n";

			//echo "<td class=\"".strtoupper($row2)."\">";
			$nicevar = null;
			if ($linkwith != null && $linkwith == $row2) {
				if ($linkfrom != null) {
					$nicevar = $row[$linkfrom];
				}else {
					$nicevar = $row[$row2];
				}
			}


			if ($nicevar != null) {
				echo "<td class=\"ANCHOR\">";
				echo "<a href = \"$linkto?$getfield=".urlencode($nicevar)."\">".$row[$row2]."</a>";
			} else {
				echo "<td class=\"NORMAL\">";
				if ($trim == -1) {
					echo $row[$row2];
				} else {
					echo shorten($row[$row2], $trim);
				}
			}
			echo "</td>\n";
			/*echo "<td class=\"NOTES\" >";
				echo $row["Notes"];
			echo "</td>";*/
		}
		echo "</tr>\n";
	}
	mysql_free_result($result);
	echo "</table>\n";
}


function search($plain_search, $table, $rows, $start = 0, $length = 10000) {
	$sql = NULL;
	//$plain_search = $_GET["search"];
	$search="%".$plain_search."%";
	if ($search) {
		$search = strtolower($search);
		//$search_sql = "WHERE `Latin Name` LIKE '$search' || `Common Name` LIKE '$search' ";
		 
		$search_sql = "WHERE LOWER(`$rows[0]`) LIKE '$search' ";

		for ($i = 1; $i < count($rows); $i++) {

			$search_sql = $search_sql."|| LOWER(`".$rows[$i]."`) LIKE '$search' ";
		}

		$sql = "SELECT * FROM `$table` ".$search_sql."ORDER BY `$table`.`$rows[0]` ASC LIMIT $start , $length";
	} else {
		$sql = "SELECT * FROM `$table` ORDER BY `$table`.`$rows[0]` ASC LIMIT $start , $length";
	}
	$result = safe_query($sql);
	$total_count = mysql_num_rows(safe_query("SELECT * FROM `$table`"));

	/*if ($plain_search) {
	 $no = mysql_num_rows($result);
	echo "<p>showing $no result".($no == 1?"":"s")." for search '$plain_search'</p>";
	} else {
	$no = mysql_num_rows($result);
	$page = ($start/$length) + 1;
		
	echo "<p>showing page $page of $total_count records.</p>";
	}*/
	return $result;
}

function echo_nav($file, $search, $count, $off) {
	echo "\n\n<p>\n";
	echo "<a href=\"$file?search=$search&amp;count=$count&amp;offset=".($off - $count)."\">Prev</a>\n";
	echo "<a href=\"$file?search=$search&amp;count=$count&amp;offset=".($off + $count)."\">Next</a>\n";
	echo "</p>\n";
}

function echo_text($result, $search, $off, $count, $total_count) {
	$no = mysql_num_rows($result);
	$page = ($off/$count) + 1;
	$total_pages = ceil($total_count/$count);
	$total_pages = $total_pages < 1 ? 1 : $total_pages;
	if ($search) {
		echo "<p>Showing page $page of $total_pages pages ($total_count records found for search)</p>";
	} else {
		echo "<p>Showing page $page of $total_pages pages ($total_count records)</p>";
	}


}

function echo_count_chooser($file, $search, $count) {
	echo "
	<a href=\"javascript:toggleVisibility('invis')\">Show/Hide options...</a>
	<div id=\"invis\" style=\"display:none;\">
		<form action=\"$file\" method=\"get\" class=\"INVISIBLE\">\n
			<table class=\"INVISIBLE\">
				<!--<tr>
					<td>Page no:</td>
					<td><input type=\"text\" name=\"page\"></input><br/></td>
				</tr>-->
				<tr class=\"INVISIBLE\">
					<td class=\"INVISIBLE\">Records per page:</td>
					<td class=\"INVISIBLE\">
						<div><input type=\"text\" name=\"count\" value=\"$count\"><br/></div>
					</td>
				</tr>
				<tr class=\"INVISIBLE\">
					<td class=\"INVISIBLE\"> </td>
					<td align=\"right\" class=\"INVISIBLE\"><input type=\"submit\" value=\"GO\"> </td>
				</tr>
			</table>
			<div><input type=\"hidden\" name=\"search\" value=\"$search\"></div>
		</form>
	</div>";
}

function echo_toggle_visibility_script() {
	echo '<script type="text/javascript">
function toggleVisibility(controlId)
{
	var control = document.getElementById(controlId);
	control.style.display = (control.style.display == "none") ? "block" : "none";
}
</script>';
}
function shorten($string, $length = 150, $ellipse = "...") {
	if (strlen($string) <= $length) {
		return $string;
	}
	return substr($string, 0, $length).$ellipse;
}

/*
 *
* Nice function does nice stuff
*/
function nav_controls($page, $http_query, $pageno, $amount, $allcount) {
	//echo htmlspecialchars(var_dump($http_query));
	$http_query["pageno"] = 0;
	echo "<p><a href=\"$page?".http_build_query($http_query,"","&amp;")."\">First</a> ";


	if ((($pageno/$amount)+1) > 1) {
		$http_query["pageno"] = $pageno-$amount;
		echo " <a href=\"$page?".http_build_query($http_query,"","&amp;")."\">Prev</a> ";
		//echo "<a href=query.php?full=$full&pageno=".($pageno-$amount)."&amount=".($amount).">Prev page</a> ";
	}
	echo " Page ";
	echo (($pageno/$amount)+1);
	echo " of ";
	echo ceil(($allcount/$amount));

	if ((($pageno/$amount)+1) < ceil(($allcount/$amount))) {
		$http_query["pageno"] = $pageno+$amount;
		echo " <a href=\"$page?".http_build_query($http_query,"","&amp;")."\">Next</a> ";

		//echo "<a href=query.php?full=$full&pageno=".($pageno+$amount)."&amount=".($amount).">Next page</a> ";

	}
	//echo $allcount - $amount;
	if (($allcount - $amount)>0) {
		$http_query["pageno"] = ceil(($allcount - $amount)/$amount)*$amount;//round($allcount - $amount, -2);

	}else {
		$http_query["pageno"] = 0;
	}
	echo " <a href=\"$page?".http_build_query($http_query,"","&amp;")."\">Last</a></p>\n";
}


function letter_index($page, $class) {
	echo "<p class=\"$class\"><b>";
	#echo chr(65);#.to_string();
	for ($char = 65; $char <= 90; $char++) {
		echo "<a href=\"$page?letter=".chr($char)."\">".chr($char)."</a> ";
	}
	echo "</b></p>\n";
}



function link_to_book2($string) {
	$regex = '/(?<=\[|,\s)(\d*)(?=,\s|\])/';

	preg_match_all($regex, $string, $matches);

	$rep = array();
	$pat = array();
	for ($i = 0; $i < count($matches[1]); $i++) {
		$pat[$i] = $regex;#"/{$matches[$i]}/";
		$rep[$i] = '<a href="refs.php#$1">$1</a>';
	}
	$newstring = preg_replace($pat, $rep, $string, -1, $count);
			  
	return $newstring;
}

function OutputBookRefRecord($row, $hover = true) {
	
	$result = safe_query("DESCRIBE `References`");
	if (!$result) {
		echo 'Could not run query: ' . mysql_error();
		exit;
	}
	$out = "";
	if (mysql_num_rows($result) > 0) {
		#echo '<dl class="refview">';
		$out .= "<dl class=\"refview\">";
		while ($row1 = mysql_fetch_row($result)) {
			$col_name = $row1[0];
			if(!array_key_exists($col_name,$row)) {
				continue;
			}
			if (!$hover & $col_name == "Title") {
				$out .=  "<dt>".$col_name."</dt>";
				$out .=  "<dd><h3 style=\"margin-bottom:0px;\">";
				$out .=	"Ref: ".$col_no." - ";
				$out .=  link_to_book2(htmlspecialchars($row[$col_name]));
				$out .=  "</h3></dd>\n";
				continue;
			}
			if ($col_name == "No") {
				$col_no = $row[$col_name];
				continue;
			}
			if ($col_name == "Href") {
				if(!empty($row[$col_name]) ) {
					#echo "<dt>Website</dt>";
					#echo "<dd>";
					$out .= "<dt>Website</dt>";
					$out .= "<dd>";
					
					$url = $row[$col_name];

					if (!parse_url($url, PHP_URL_SCHEME) && $url) {
						$url = "http://$url";
					}
					$url = htmlspecialchars($url);
					#echo "<a target=\"_blank\" href=\"".$url."\">".$url."</a>";
					#echo "</dd>\n";
					$out .= "<a target=\"_blank\" href=\"".$url."\">".$url."</a>";
					$out .= "</dd>\n";
					
				}
			} else {
				#echo "<dt>".$col_name."</dt>";
				#echo "<dd>";
				#echo link_to_book2($row[$col_name]);
				#echo "</dd>\n";
				$out .=  "<dt>".$col_name."</dt>";
				$out .=  "<dd>";
				$cont = link_to_book2(htmlspecialchars($row[$col_name]));
				$out .=  $cont == ""?"&nbsp;":$cont;
				$out .=  "</dd>\n";
			}
		}
		#echo "</dl>\n";
		$out .=  "</dl>\n";
	}
	return $out;
}

function BookRef() {

	if (empty($_GET["id"])) {
		trigger_error("A book ID should be specified");
		return;
	}
	$key = mysql_real_escape_string($_GET["id"]);
	
	if ($key == "K") {
		echo "<title>Plants for a Future</title>";
		echo "</head>\n<body>";	
		echo '<div class="CONTENT">';
		OutputBookRefRecord( array("No" => "K", "Title" => "Plants for a Future", "Author" => "Ken Fern ", "Description" => "Notes from observations, tasting etc at Plants For A Future and on field trips."));

		#mysql_close($db);
		return;
	}

	$result = safe_query("SELECT * FROM `References` WHERE `No` = $key");
	
	$row = mysql_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['Title']."</title>";
		echo "</head>\n<body>";	
		echo '<div class="CONTENT">';

		OutputBookRefRecord($row);
	} else {
		echo "<title>".$key."</title>";
		echo "</head>\n<body>";
		echo '<div class="CONTENT">';

		echo "<p><b>No record for \"".$key."\"</b></p>";
		
	}
	mysql_free_result($result);

}

function find_images($name) {
	$imgs = array();
	$result = safe_query("SELECT `FileName`, `Caption`, `Author`, `AuthorRef`, `Attribution`, `AttributionRef` FROM `PlantPictures` WHERE `LatinName` = '$name'");
	while ($row = mysql_fetch_array($result)) {
		$imgs[] = array("file" => $row[0], "caption" => $row[1], "author" => $row[2], "author_ref" => $row[3], "attribution" => $row[4], "attribution_ref" => $row[5]);
	}
	return $imgs;
}

/*
 * Return a filename for a downscaled image
 * */
function sized_image($filename, $w = 480) {
	//create a new filename for the resized image
	$ext = substr($filename,-4,4);
	$pre = substr($filename,0,-4);
	$resized = $pre."_".$w."px".$ext;
	
	$resized = dirname($filename)."/sized/".basename($resized);
	//check for an allready resized image, and return that if possible
	if (file_exists($resized)) {
		return $resized;
	} else {
		list($curr_w, $curr_h, $type) = getimagesize($filename);
		//don't bother resizing if it's not necesarry
		if ($curr_w <= $w ) {
			return $filename;
		}
		// keep the image the same aspect ratio
		$ratio = $curr_w/$curr_h;
		$h = $w/$ratio;
		//load depending on format, could use a switch, but i don't like it
		if ($type == IMAGETYPE_JPEG) {
			$curr_img = imagecreatefromjpeg($filename);
		}else if ($type == IMAGETYPE_GIF) {
			$curr_img = imagecreatefromgif($filename);
		}else if ($type == IMAGETYPE_PNG) {
			$curr_img = imagecreatefrompng($filename);
		}
		
		$new_img = imagecreatetruecolor($w,$h);		
		imagecopyresampled($new_img, $curr_img, 0, 0, 0, 0, $w, $h, $curr_w, $curr_h);
		
		imagejpeg($new_img, $resized, 99);
		imagedestroy($curr_img);
		imagedestroy($new_img);
		
		return $resized;
	}
}

function output_bananas($no) {
	return output_graphic($no, "banana.png");
}

function output_other($no) {
	return output_graphic($no, "other.png");
}

function output_greeny($no) {
	return output_graphic($no, "medi.png");
}

function output_graphic($no, $graphic, $words = 1337) {
	if ($words==1337) {
		$words = array(
		"0 - The plant has no uses in that category", 
		"1 - We either have insufficient information (ie ‘The plant".
		" has medicinal uses’) or its use is incredibly minor or has".
		" significant negative drawbacks - such as being poisonous.", 
		"2 - Minor uses, or probably minor uses, with no significant".
		" drawbacks", 
		"3 - A probably quite useful plant, often only used locally. There".
		" are various criteria for judging this. For example, the plant".
		" might be cultivated locally; it might be gathered from the wild".
		" and sold in local markets; it might have a reference to being".
		" locally popular.", 
		"4 - A very useful plant, probably cultivated outside of its".
		" native range. Also includes lesser known plants that I feel have".
		" a big potential.", 
		"5 - Exceptionally useful. Some of the best known medicinal herbs,".
		" food etc are included here, but also some lesser known plants".
		" that I feel have exceptional potential");
	}
	$monkey = "";
	$banana = '<img src="'.$graphic.'" width="24" alt=" * "/>';
	for ($i = 0;$i < $no; $i ++) {
		$monkey=$monkey.$banana;
	}
	return '<span style="display:block;margin:0px;height:24px" title="'.$words[$no].'">'.$monkey.'</span>';
}

?>
