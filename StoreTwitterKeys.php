<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include_once "twitteroauth/autoload.php";
include_once "twitter/twitteroauth.php";
include_once "config/twconfig.php";
include_once "config/functions.php";
//use Abraham\TwitterOAuth\TwitterOAuth;

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

//========================BEGIN getTwitterData.php addition

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
    
    // Let's request the access token
    $oauth_verifier = $_GET['oauth_verifier'];
    $access_token = $twitteroauth->getAccessToken($oauth_verifier);
    
    //Requests user info from twitter
    $user_info = $twitteroauth->get('account/verify_credentials');
    
    //Following if statement checks for an error with getting $user_data. (One reason could be expired tokens, idk).
    if (isset($user_info->error)) {
        echo "Something went wrong in StoreTwitterKeys.php. Error in isset($user_info->error) if statement."."<br />";
    } else {
        $twitter_otoken = $_SESSION['oauth_token'];
	    $twitter_otoken_secret = $_SESSION['oauth_token_secret'];
	    $twitter_otoken_p = $access_token['oauth_token'];
	    $twitter_otoken_secret_p = $access_token['oauth_token_secret'];
	    $email='Unknown';
        //$name is twitter display name. (e.g. 'Michael Snook') 
        $name = $user_info->name;
        //$screenname is the unique twitter username. (e.g. '@Snooooooook')
        $screenname = $user_info->screen_name;
        //uid is something like 78569875976
        $uid = $user_info->id;
        $user = new User();
        $provider = 'twitter';
        $cuser = $_SESSION['username'];

        
        //Check if user is already in database, if not, add them.
        $newUser = $user->checkUser($uid, $provider, $screenname, $name, $email, $twitter_otoken, $twitter_otoken_secret, $oauth_verifier, $twitter_otoken_secret_p, $twitter_otoken_p, $cuser);
        echo "OK";
        $_SESSION['authTW'] = true;
        
        // unset $_SESSION variables that are no longer used.
        unset($_SESSION['oauth_token']);
        unset($_SESSION['oauth_token_secret']);
        header('Location: http://censureapp.com/signupauth.php');
    }
}
else{
    echo "Oops...Something isn't right!";
}
?>