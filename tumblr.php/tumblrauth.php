<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once 'vendor/autoload.php';
require_once 'tumblrkeys.php';
require_once '../config/dbconfig.php';
$tmpToken = isset($_SESSION['tmp_oauth_token'])? $_SESSION['tmp_oauth_token'] : null;
$tmpTokenSecret = isset($_SESSION['tmp_oauth_token_secret'])? $_SESSION['tmp_oauth_token_secret'] : null;
$client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $tmpToken, $tmpTokenSecret);
$requestHandler = $client->getRequestHandler();
$requestHandler->setBaseUrl('https://www.tumblr.com/');
if (!empty($_GET['oauth_verifier'])) {
    $verifier = trim($_GET['oauth_verifier']);
    $resp = $requestHandler->request('POST', 'oauth/access_token', array('oauth_verifier' => $verifier));
    $out = (string) $resp->body;
    $data = array();
    parse_str($out, $data);
    unset($_SESSION['tmp_oauth_token']);
    unset($_SESSION['tmp_oauth_token_secret']);
    $_SESSION['Tumblr_oauth_token'] = $data['oauth_token'];
    $_SESSION['Tumblr_oauth_token_secret'] = $data['oauth_token_secret'];
}
if (empty($_SESSION['Tumblr_oauth_token']) || empty($_SESSION['Tumblr_oauth_token_secret'])) {
    $callbackUrl = 'http://censureapp.com/tumblr.php/tumblrauth.php';
    $resp = $requestHandler->request('POST', 'oauth/request_token', array('oauth_callback' => $callbackUrl));
    $result = (string) $resp->body;
    parse_str($result, $keys);
    $_SESSION['tmp_oauth_token'] = $keys['oauth_token'];
    $_SESSION['tmp_oauth_token_secret'] = $keys['oauth_token_secret'];
    $url = 'https://www.tumblr.com/oauth/authorize?oauth_token=' . $keys['oauth_token'];
    header('Location: '.$url);
    exit;
}
$token = $_SESSION['Tumblr_oauth_token'];
$secret = $_SESSION['Tumblr_oauth_token_secret'];
unset($_SESSION['Tumblr_oauth_token']);
unset($_SESSION['Tumblr_oauth_token_secret']);
$username = "'".$_SESSION['username']."'";
$client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $token, $secret);
$name = $client->getUserInfo()->user->name;
$database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
$query = "SELECT * FROM Tumblr WHERE username = $username";
$result = mysqli_query($database, $query);
if($result) {
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        //EXISTS
    } else {
        $query = "INSERT INTO Tumblr (username, oauth_token, oauth_secret, blogname) VALUES ($username, '$token', '$secret', '$name')";
        $success = mysqli_query($database, $query);
        $_SESSION['authTB'] = true;
        header('Location: http://censureapp.com/signupauth.php');
    }
}
?>