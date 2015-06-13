<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//Logged into Censure application
$_SESSION['login'] = "1";

require 'config/twconfig.php';
require 'config/functions.php';
require "twitteroauth/autoload.php";
//require "twitter/twitteroauth.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//======================================Twitter======================================

$user = new User();
//gets Access tokens based off of the twitter screename. Potential vulnerability.
$tokens_array = $user->getTwitterTokens($_SESSION['tw_screename']);
$twitter_otoken_secret =$tokens_array[3];
$twitter_otoken = $tokens_array[4];
$oauth_verifier = $tokens_array[2];
echo "<br />"."secret: ".$twitter_otoken_secret;
echo "<br />"."token: ".$twitter_otoken;
echo "<br />"."verifier: ".$oauth_verifier."<br />";

//Establish a new connection
$connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);

//Get user's timeline
$timeline = $connection->get("statuses/user_timeline?count=1");
$loops = $timeline['statuses_count'] / 200;
$extra = $timeline['statuses_count'] % 200;
if($extra > 0) {
    $loops++;
}
if($loops > 5) {
    $loops = 5;
}
$stopid = ""; $totalget = 200;
for ($i = 0; $i < $loops; $i++) {
    $counter = 1;
    $request = "statuses/user_timeline?count=" + $totalget + $stopid;
    $timeline = $connection->get($request);

    foreach($timeline as $tweet){
        echo "Tweet ". $counter.": \"".$tweet->text."\"->"."id: ".$tweet->id."<br />";
        $counter++;
        if($counter == 200) {
            $stopid = "&max_id=" + $tweet->id;
     }   
}
if($extra > 0 && $i == ($loops - 2)) {
        $totalget = $extra
    }
}
?>