<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//Always place this code at the top of the Page
session_start();

//Logged into Censure application
//$_SESSION['login'] = "1";
$_SESSION['tw_screename'] = "Snooooooook";


require '../config/twconfig.php';
require '../config/functions.php';
require "../twitteroauth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;


$user = new User();
$tokens_array = $user->getTwitterTokens($_SESSION['tw_screename']);

$twitter_otoken_secret =$tokens_array[0];
$twitter_otoken = $tokens_array[1];
echo $twitter_otoken_secret."<br />".$twitter_otoken."<br />";


    $connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);
    //var_dump($connection);

    $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
    $_SESSION['access_token'] = $access_token;
    $connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $connection->get("account/verify_credentials");

   
   
    if ($connection->getLastHttpCode() == 200) {
        echo "yay"."<br />";
    } else {
        echo "no"."<br />";
    }

    $timeline = $connection->get("statuses/user_timeline");
    $counter = 1;
    foreach($timeline as $tweet){
        echo "Tweet ". $counter.": \"".$tweet->text."\"->"."id: ".$tweet->id."<br />";
        $counter = $counter + 1;
    }


?>