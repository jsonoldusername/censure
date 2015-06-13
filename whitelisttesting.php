<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'CensorWords.php';
require_once 'socialPosts/socialPost.php';

$censoredPost = "";
$numberOfSwears = 0;

$post = "I went to class today on an ass.";
echo $post . "<BR>";

$censorWords = new CensorWords; 
$words = explode(" ", $post);
$length = count($words);
foreach ($words as $word){
    $result =  $censorWords->censorString($word);
    if ($words[$length - 1] != $word){
        $censoredPost .=$result['clean']." ";
    }
    else{
        $censoredPost .=$result['clean'];
    }
    $numberOfSwears +=$result['count'];
}

echo $numberOfSwears;

//foreach ($censorWords->asswords as $word) echo $word . "<BR>";

?>