<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'CensorWords.php';
require_once 'socialPosts/socialPost.php';

$post = "Hello, my name is Aaron";
$numberOfMisspellings = 0;

$words = explode(" ", $post);
foreach ($words as $word){
    if (!$this->check_word($word, $this->dictarray)) {
        $numberOfMisspellings++;
    }
}

echo $numberOfMisspellings;

?>