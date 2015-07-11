<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require '../config/dictconfig.php';
use dictconfig;

$dictfile = fopen("/var/www/html/censure/config/engl_words_350k.txt", "r") or die("Unable to open file!");
$dictarray = array();

while (!feof($dictfile)){
	array_push($dictarray, trim(fgets($dictfile)));
}
fclose($dictfile);

$post = "@nucl0tides the @FifthSeasonofCR is smell. No question.";
echo $post . "<BR>";
$misspellings = 0;
$words = explode(" ", $post);
foreach ($words as $word){
    echo $word;
    if (ctype_alpha($word)) echo " ALL LETTERS ";
    if (!check_word($word, $dictarray)) {
        echo " NOT A WORD ";
        $misspellings++;
    }
    echo "<BR>";
}
echo $misspellings;

/*$counter = 0;
while ($counter < 150000){
    echo $dictarray[$counter] . "<BR>";
    $counter++;
}*/
?>