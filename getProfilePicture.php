<?php
session_start();
include_once 'config/twconfig.php';
include_once "config/functions.php";
include_once "twitteroauth/autoload.php";
include_once 'socialPosts/twitterPost.php';
include_once 'GrantTest/getFBPic.php';
include_once 'tumblr.php/tumblrprofile.php';

use Abraham\TwitterOAuth\TwitterOAuth;

function getPic() {
        $username = "'".$_SESSION['username']."'";
        $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
        if(isset($_SESSION['authFB'])) {
        if($_SESSION['authFB'] == true) {
            $SQL = "SELECT * FROM Facebook WHERE username = $username";
            $result = mysqli_query($connection, $SQL);
            if ($result) {
                $num_rows = mysqli_num_rows($result);
                if ($num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $token = $row["token"];
                            return getFBPic($token);
                        }
                }
            } 
        }
} else if(isset($_SESSION['authTW'])) {
    if($_SESSION['authTW'] == true) {
    $SQL = "SELECT * FROM Twitter WHERE username = $username";
    $result = mysqli_query($connection, $SQL);
    if ($result) {
	    $num_rows = mysqli_num_rows($result);
	    if ($num_rows > 0) {
	        $user = new User();
            $row = $result->fetch_assoc();
            $tw = $row["screenname"];
            $tokens_array = $user->getTwitterTokens($username);
            $twitter_otoken_secret =$tokens_array[3];
            $twitter_otoken = $tokens_array[4];
            $oauth_verifier = $tokens_array[2];
            $connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);
            $timeline = $connection->get("users/show", array('screen_name'=> $tw));
            return $timeline->profile_image_url;
        }
    } 
}
} else {
    return getTBPic();
}
}
?>