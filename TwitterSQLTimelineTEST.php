<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'config/functions.php';
$user = new User();

var_dump($_SESSION);

if(isset($_SESSION['username'])){
    $uname = "'".$_SESSION['username']."'";
    $tokens_array = $user->getTwitterTokens($uname);
} else {
    //ERROR
}
$counter = 1;
echo "<br />";
echo('<div style="color: red;">We recommend removing the following tweets: </div>');
echo "<br />";
$twitter_otoken_secret =$tokens_array[3];
$twitter_otoken = $tokens_array[4];
$oauth_verifier = $tokens_array[2];

//Establish a new connection
$connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);

//Get user's timeline
$timeline = $connection->get("statuses/user_timeline");

$pics = array();
echo "array initialized";
foreach($timeline as $tweet){
    echo "<br /><br /><br />";
    //var_dump($tweet); 
    echo $tweet->text."<br />";
    
    $tp = new twitterPost($tweet);
    
    var_dump($tp->media);
    
    echo "<br />";
    
    
    
    
    /*if (array_key_exists("extended_entities", $tweet)){
	        //foreach($tweet->extended_entities->media as $pic){
	        //    array_push($pics, $pic->media_url);
	        //}
	        echo "extended_entities exists in tweet.<br />";
	        //var_dump($tweet->extended_entities->media);
	        foreach($tweet->extended_entities->media as $pic){
	            echo $pic->media_url."<br />";
	            array_push($pics, $pic->media_url);
	        }
	}*/
}

//echo "<br /><br /><br />Media (extended_entities):<br /><br />";
//var_dump($pics);

?>