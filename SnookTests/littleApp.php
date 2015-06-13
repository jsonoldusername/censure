<?php
require_once('TwitterAPIExchange.php');
/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
'oauth_access_token' => "2997277308-clAVZVnqLJ5WYKYENfQQnIjt2qaZILM1AteshcK",
'oauth_access_token_secret' => "7xPrdqCIaSK1VRCPYMDEncpcGZE1OMHXTD4i2sGULxSOs",
'consumer_key' => "umgBoc5sHw4DU7yqYcrd3CS60",
'consumer_secret' => "CzJUyHzaI00ixDsewj8T0ZImjiRnWh2o9SEuLEk5Wv9lVluZrO"
);
$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
$requestMethod = "GET";
if (isset($_GET['user']))  {$user = $_GET['user'];}  else {$user  = "Censure309";}
if (isset($_GET['count'])) {$user = $_GET['count'];} else {$count = 1000;}
$getfield = "?screen_name=$user&count=$count";
$twitter = new TwitterAPIExchange($settings);
$string = json_decode($twitter->setGetfield($getfield)
->buildOauth($url, $requestMethod)
->performRequest(),$assoc = TRUE);
if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}
$counter = 1;
foreach($string as $items)
    {
    	if(strpos($items['text'],"fuck")){
    		$items['text'] = "########RED FLAG, CONSIDER REMOVING: ".$items['text']."#########";
    	}
    	//	$items['text'] = 'RED FLAG, CONSIDER REMOVING: '.$items['text'];
    	//}
        //echo "Time and Date of Tweet: ".$items['created_at']."<br />";
        echo $counter.". Tweet: ". $items['text']."<br />";
        $counter = $counter + 1;
        //echo "Tweeted by: ". $items['user']['name']."<br />";
        //echo "Screen name: ". $items['user']['screen_name']."<br />";
        //echo "Followers: ". $items['user']['followers_count']."<br />";
        //echo "Friends: ". $items['user']['friends_count']."<br />";
        //echo "Listed: ". $items['user']['listed_count']."<br /><hr />";
    }
?>
