<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require "../twitteroauth/autoload.php";
require "../config/twconfig.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$access_token = "937847216-qI9MLNgNqfnJaYfmzMQ0rRSW75l2rLJJHTwBjofi";
$token_secret  = "AeUenHoDFM6KOj41ANYgQ73bb6U4RlxTTKKj0oLLlcKrk";

$connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $access_token, $token_secret);
var_dump($connection);


//POST status
$statuses = $connection->post("statuses/update", array("status" => "Hello everyone. Michael Snook is the coolest person ever. #Snooooooooooooook"));
var_dump($statuses);

/*if ($connection->getLastHttpCode() == 200) {
    echo "yay"."<br />";
} else {
    echo "no"."<br />";
}*/
//echo "<br />";
//$timeline = $connection->get("statuses/user_timeline");
//$counter = 1;
//foreach($timeline as $tweet){
//    echo "Tweet ". $counter.": \"".$tweet->text."\"->"."id: ".$tweet->id."<br />";
//    $counter = $counter + 1;
//}
?>