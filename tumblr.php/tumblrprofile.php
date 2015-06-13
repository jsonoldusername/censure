<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once dirname(__FILE__).'/../tumblr.php/tumblrkeys.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrtokens.php';
require_once 'vendor/autoload.php';

function getTBPic() {
    $access = getTumblrTokens($_SESSION['username']);
    $client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $access[0], $access[1]);
    $blogName = $client->getUserInfo()->user->name;
    return $client->getBlogAvatar($blogName);
}

?>