<?php
	include 'functions.php';
	include 'dbconnect.php';
	$typed = $_GET["typed"]."%";
	$query = "SELECT `Latin name` FROM `tropicalspecies` WHERE `Latin name` LIKE ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, 's', $typed);

    if (mysqli_stmt_execute($stmt)) {
		mysqli_stmt_bind_result($stmt, $out);
		while (mysqli_stmt_fetch($stmt)) {
			echo $out.";";
		}
    }
	mysqli_stmt_close($stmt);	
?>
