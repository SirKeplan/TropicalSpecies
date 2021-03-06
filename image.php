<?php
	include 'functions.php';
	include 'dbconnect.php';
	
	if (empty($_GET["id"])) {
		emailError(51, "A plant name must be supplied.",$_SERVER['REQUEST_URI'],"","");
		//redirect to index page
		header('Location: ./', TRUE, 303);
		die;
	}
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width">
  <link rel=stylesheet href="style.css" type="text/css">
  <link rel="shortcut icon" href="flower.ico">


<?php
	function output_img_page($row) {	
		echo '<h1 class="latin_name">'.$row['LatinName']." Images</h1>";
		echo '<a href="viewtropical.php?id='.urlencode($row['LatinName']).'">Back to plant info.</a>';
		echo '<br/>';
		
		$imgdata = null;
		$imglist = find_images($row['LatinName']);

		if (empty($imglist)) {
			echo '<div class="NOIMAGE">No Image.</div>';
		}
		foreach ($imglist as $imgdata) {
			global  $images_path;
			$filename = $images_path.$imgdata["file"];
			if ($imgdata and file_exists($filename)) {
				echo '<a href="'.$filename.'"><img class="big_pic" src="'.sized_image_bounded($filename,960, 9999).'" id="'.$filename.'" alt="'.$row['LatinName'].'"/></a>';
				output_image_info($imgdata);

			} else {
				echo '<div class="NOIMAGE">No Image.</div>';
				trigger_error("Image ".$filename." for ".$row['LatinName']." is in database but the file can not be found!");
			}
			echo "<br/>\n";
		}		
	}
	
	$key = mysqli_real_escape_string($db, $_GET["id"]);

	$redir = null;
	if (! empty($_GET["redir"])) {
		$redir = mysqli_real_escape_string($db, $_GET["redir"]);
	}

	$result = safe_query($db, "SELECT * FROM `PlantPictures` WHERE LCASE(`LatinName`) = LCASE('$key')");
	
	$row = mysqli_fetch_assoc($result);
	if ($row) {
		echo "<title>".$row['LatinName']." Images - Useful Tropical Plants</title>";
		echo "</head>\n<body>";	
		include 'header.php';

		global $redir;
		global $row;
		output_img_page($row);
	} else {
		echo "<title>No Record - Useful Tropical Plants</title>";
		echo "</head>\n<body>";
		include 'header.php';
		$names = array();
		#mysqli string comparisons aren't case sensitive, no need to convert case
		$synresult = safe_query($db, 'SELECT * FROM `Synonyms`WHERE `LatinName` = "'.$key.'"');
		while ($row = mysqli_fetch_assoc($synresult)) {
			$names[] = $row["TrueLatinName"];
		}
		if (count($names) < 1) {
			echo "<p>We have no record for <b>\"".htmlspecialchars($key)."\"</b></p>";
			echo "<p>Try running a search.</p>";

		} else if (count($names) == 1) {
			#redirect...
			header('Location: image.php?id='.urlencode($names[0]).'&redir='.urlencode($key), TRUE, 303);
			#script shouldn't actualy reach here in theory
			echo '<p>You probably want:';
			echo '<a href="image.php?id='.urlencode($names[0]).'&redir='.urlencode($key).'">'.$names[0].'</a>';
			echo '</p>';
		}else {
			echo "<p>No record for <b>\"".$key."\"</b></p>";
			echo "<p>\"$key\" is a synonym of the following plants.</p>";
			mysqli_data_seek($synresult, 0);
			output_table_query($synresult, "Nothing", "Synonyms", null, "TrueLatinName", "image.php", "id",-1 , array("LatinName"), array("TrueLatinName" => "LatinName", "Author" => "Author"));
			#print_r( $names);
		}
		
	}
	mysqli_free_result($result);
	include 'footer.php';
	mysqli_close($db);
?>

</body>
</html>
