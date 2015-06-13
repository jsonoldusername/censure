<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "2997277308-clAVZVnqLJ5WYKYENfQQnIjt2qaZILM1AteshcK",
'oauth_access_token_secret' => "7xPrdqCIaSK1VRCPYMDEncpcGZE1OMHXTD4i2sGULxSOs",
'consumer_key' => "umgBoc5sHw4DU7yqYcrd3CS60",
'consumer_secret' => "CzJUyHzaI00ixDsewj8T0ZImjiRnWh2o9SEuLEk5Wv9lVluZrO"
);
$url = 'https://api.twitter.com/1.1/statuses/destroy/Censure309.json';
$postfields = array('id' => 'Censure309');
$requestMethod = 'POST';

$twitter = new TwitterAPIExchange($settings);
$response =  $twitter->buildOauth($url, $requestMethod)
    ->setPostfields($postfields)
    ->performRequest();

var_dump(json_decode($response));

print( '<a href="http://home.engineering.iastate.edu/~snook/snook/">Delete Tweets</a>' );
?>
