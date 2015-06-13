<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function check_word($word, $dictionary){
	if (!ctype_alpha($word) || strlen($word) <= 3) return 1;

	$min = 0;
	$max = count($dictionary) - 1;
	while($min <= $max){
		$current = floor(($max - $min)/2 + $min);
		if (strcasecmp($dictionary[$current], $word) == 0) return 1;
		else if (strcasecmp($dictionary[$current], $word) > 0){
			$max = $current - 1;
		}
		else{
			$min = $current + 1;
		}
	}
	return 0;
}


?>