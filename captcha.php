<?php



if (($q = $_GET["q"]) && ($a = $_GET["a"])) {
	echo is_correct($q, $a)?1:0;
}

function is_correct($question_id, $answer) {
	$questions = array(
		"How many fingers does the typical human have?" => 10,
		"Type the digit seven into the box" =>	7,
		"if i have 3 bananas, and i eat them all, how many bananas did i dust eat?" => 3,
		"divide 6 by 2" => 3,
		"3 times 3 is?" => 9,
		"subtract 1 from 12" => 11
	);
	return $questions[$question_id] == $answer;
}
?>
