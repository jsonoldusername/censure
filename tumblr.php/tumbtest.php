<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require_once 'vendor/autoload.php';
require_once '../socialPosts/tumblrPost.php';
require_once 'tumblrkeys.php';
require_once 'tumblrtokens.php';
require_once '../config/functions.php';

$user = new User();
$username = $_SESSION['username'];
$custom = null;
$dirtyTumblr = $user->getDirtyTumblr($username, "Basic", $custom);
$counter = 0;
foreach($dirtyTumblr as $tumblrPost) {
    echo($counter.$tumblrPost->text);
    $counter++;
}
?>