<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once dirname(__FILE__).'/../tumblr.php/tumblrkeys.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrtokens.php';
require_once 'vendor/autoload.php';

function getAllTumblrPosts($username) {
    $all = array();
    $access = getTumblrTokens($username);
    $client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $access[0], $access[1]);
    $blogName = $client->getUserInfo()->user->name;
    foreach($client->getBlogInfo($blogName) as $test) {
        $total = $test->posts;
    }
    $gets = 20; $totes = 0; $total = 60;
    while($totes < $total) {
        foreach($client->getBlogPosts($blogName, array('filter' => "text", 'limit'=> $gets,'offset'=> $totes))->posts as $postx) {
            array_push($all, $postx);
        }
        $totes += $gets;
    }
    return $all;
}

?>