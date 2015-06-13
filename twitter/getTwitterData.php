<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
ob_start();
require("twitteroauth.php");
require '../config/twconfig.php';
require '../config/functions.php';
require '../config/dbconfig.php';
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
    echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
    } else {
	   $twitter_otoken=$_SESSION['oauth_token'];
	   $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
	   $email='test';
        $uid = $user_info->id;
        $username = $user_info->name;
        $user = new User();
        $provider = 'twitter';
        $userdata = $user->checkUser($uid, $provider, $username, $email, $twitter_otoken, $twitter_otoken_secret);
        if(!is_null($userdata)){
            $row = $userdata->fetch_row();
            $_SESSION['oauth_provider'] = $row[1];
            $_SESSION['usernametwitter'] = $row[2];
            $_SESSION['oauth_id'] = $uid;
            //$_SESSION['id'] = WHAT?;
            $_SESSION['twitterlogin'] = true;
            header("Location: home.php");
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>