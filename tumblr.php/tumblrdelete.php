<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once dirname(__FILE__).'/../tumblr.php/tumblrkeys.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrtokens.php';
require_once 'vendor/autoload.php';

function deleteTumblr($identifier) {
    $access = getTumblrTokens($_SESSION['username']);
    echo($access[1]);
    $client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $access[0], $access[1]);
    $blogName = $client->getUserInfo()->user->name;
    $client->deletePost($blogName, $identifier, null);
}

?>