<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once "twitteroauth/autoload.php";
include_once "twitter/twitteroauth.php";
include_once "config/twconfig.php";
include_once "config/functions.php";
include_once "tumblr.php/tumblrdelete.php";

$tweetid = $_POST['param1'];
$tyes = $_POST['param2'];

if($tyes > 0) {
    $user = new User();
    $u = "'".$_SESSION['username']."'";
    $tokens_array = $user->getTwitterTokens($u);
    $twitter_otoken_secret =$tokens_array[3];
    $twitter_otoken = $tokens_array[4];
    $connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);
    $connection->post('statuses/destroy/'.$tweetid);
} else {
    deleteTumblr($tweetid);
}

?>