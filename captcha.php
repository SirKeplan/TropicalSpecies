<?php
$questions = array(
		"How many fingers does the typical human have?" => 10,
		"Type the digit seven into the box" =>	7,
		"if i have 3 bananas, and i eat them all, how many bananas did i just eat?" => 3,
		"divide 6 by 2" => 3,
		"How many suns are in our solar system" => 1,
		"a square has how many sides?" => 4,
		"3 times 3 is?" => 9,
		"what is half of 100?" => 50,
		"10 times 10 is?" => 100,
		"6 plus 6 is?" => 12,
		"subtract 1 from 12" => 11
	);
if (($q = (null&&$_GET["q"])) && ($a = (null&&$_GET["a"]))) {
	echo is_correct($q, $a)?1:0;
}

function output_question() {
	global $questions;
	return $questions[array_rand($questions)];
}

function is_correct($question_id, $answer) {
	global $questions;
	
	//should allways exist, most likely a hacking attempt otherwise.
	if (!array_key_exists($question_id, $questions)) {
		emailError(88, $question_id." is not a valid captcha question", "", "27?", "answer: ".$answer);
		return false;
	}
	emailError(0, $question_id." is a captcha question", "", "30?", "answer: ".$answer);
	return $questions[$question_id] == $answer;
}
?>
