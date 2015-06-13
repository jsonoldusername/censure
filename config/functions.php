<?php

include_once 'dbconfig.php';
include_once 'twconfig.php';
include_once dirname(__FILE__).'/../twitter/twitteroauth.php';
include_once dirname(__FILE__).'/../socialPosts/twitterPost.php';
include_once dirname(__FILE__).'/../socialPosts/facebookPost.php';
include_once dirname(__FILE__).'/../socialPosts/facebookPostArray.php';
include_once dirname(__FILE__).'/../socialPosts/tumblrPost.php';
include_once dirname(__FILE__).'/../algorithm.php';
include_once dirname(__FILE__).'/../GrantTest/getFBToken.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrkeys.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrtokens.php';
include_once dirname(__FILE__).'/../tumblr.php/tumblrposts.php';
include_once dirname(__FILE__).'/../tumblr.php/lib/Tumblr/API/Client.php';
include_once dirname(__FILE__).'/../tumblr.php/lib/Tumblr/API/RequestHandler.php';
include_once dirname(__FILE__).'/../tumblr.php/lib/Tumblr/API/RequestException.php';


class User {

    function checkUser($uid, $provider, $screenname, $name, $email, $twitter_otoken, $twitter_otoken_secret, $oauth_verifier, $twitter_otoken_secret_p, $twitter_otoken_p, $uname) 
	{
        $database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
        //$query = "SELECT * FROM Twitter WHERE uid = '$uid'" or die(mysql_error());
        //$result = $database->query($query);
        //$row = $result->fetch_row();
        //$row is null if user doesn't already exist.
        //if (!is_null($row)) {
            // User is already present
         //   $result = $database->query($query);
        //} else {
            //user not present. Insert a new Record
            
            $query = "INSERT INTO Twitter (uid, oauth_provider, screenname, name, email, token_secret, token, oauth_verifier, token_secret_p, token_p, username) 
            VALUES ('$uid', '$provider', '$screenname', '$name', '$email', '$twitter_otoken_secret', '$twitter_otoken', '$oauth_verifier', '$twitter_otoken_secret_p', '$twitter_otoken_p', '$uname')";
            $success = mysqli_query($database, $query);
            //$result = $database->query($query) or die(mysql_error());
            
            //$query = "SELECT * FROM Twitter WHERE username = '$uname'" or die(mysql_error());
            //$result = $database->query($query);
        //}
        //return $result;
        return $success;
    }
    
    function getTwitterTokens($cusername) 
	{
        $database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
        $query = "SELECT * FROM Twitter WHERE username = $cusername" or die(mysql_error());
        $result = $database->query($query);
        $row = $result->fetch_row();
        //$row is null if user doesn't already exist.
        if (!is_null($row)) {
            // User is already present.
            $twitter_otoken_secret =$row[5];
            $twitter_otoken = $row[6]; 
            $oauth_verifier = $row[7];
            $twitter_otoken_p = $row[8];
            $twitter_otoken_secret_p = $row[9];
            
            $token_array = array($twitter_otoken_secret, $twitter_otoken, $oauth_verifier, $twitter_otoken_p, $twitter_otoken_secret_p);
        } else {
            #user not present. Return null.
            $token_array = null;
        }
        return $token_array;
    }
    
    function getDirtyTweets($cusername, $strictness, $custom) 
	{
        //======================================Twitter======================================
        //gets Access tokens based off of the twitter screename. Potential vulnerability.
        $tokens_array = $this->getTwitterTokens($cusername);
        $twitter_otoken_secret =$tokens_array[3];
        $twitter_otoken = $tokens_array[4];
        $oauth_verifier = $tokens_array[2];
        
        //Establish a new connection
        $connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $twitter_otoken, $twitter_otoken_secret);
        
        //Get user's timeline
        $timeline = $connection->get("statuses/user_timeline", array('count'=> 1));
        foreach($timeline as $tweet) {
            $set = $tweet->user->statuses_count;
            break;
        }
        //echo($set);
        $loops = $set / 200;
        $extra = $set % 200;
        if($extra > 0) {
            $loops++;
        }
        $allTweets = array();
        $dirtyTweets = array();
        $twitPosts = array();
        $twitPost = null;
        $test = null;
        $stopid = 0; $totalget = 200; $counter = 1;
        $dictfile = fopen("/var/www/html/cs309_g8_censure/config/engl_words_350k.txt", "r") or die("Unable to open file!");
        $dictarray = array();
        
        while (!feof($dictfile)){
        	array_push($dictarray, trim(fgets($dictfile)));
        }
        fclose($dictfile);
        for ($i = 0; $i < $loops; $i++) {
            if($stopid > 0) {
               $timeline = $connection->get("statuses/user_timeline", array('count'=> $totalget, 'max_id'=> $stopid));
            } else {
               $timeline = $connection->get("statuses/user_timeline", array('count'=> $totalget));
            }
            foreach($timeline as $tweet) {
                if($stopid != $tweet->id) {
                    //echo "Tweet ". $counter.": \"".$tweet->text."\"->"."id: ".$tweet->id."<br />";
                    //array_push($twitPosts, new twitterPost($tweet));
                    $twitPost = new twitterPost($tweet);
                    $test = new algorithm($twitPost, $strictness, $dictarray, $custom);
                    $test->runAlgorithm();
                    //if score is not 0 or 1, add it to $dirtyTweets
                    if($test->getScore() >= 1){
                        //var_dump($test);
                        //echo $test->getReason();
                        $twitPost->addReason($test->getReason());
                        array_push($dirtyTweets, $twitPost);
                    }
                    $stopid = $tweet->id;
                    $counter++;
                }
            }
            if(($i == ($loops - 2)) && ($extra > 0)) {
                $totalget = $extra;
            }
        }
        return $dirtyTweets;
    }
    
    function getDirtyFacebook($cusername, $strictness, $custom) 
	{
	    $connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
           $username = "'".$_SESSION['username']."'";
    $SQL = "SELECT * FROM Facebook WHERE username = $username";
    $result = mysqli_query($connection, $SQL);
    if ($result) {
    	$num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            while($row = $result->fetch_assoc()) {
		        //$postsObject = getGraphObject($row["token"]);
		        $feedObject = getFeed($row["token"]);
            }
        }
		$data  = (array)$feedObject;
		$allPosts = array();
        $dirtyPosts = array();
        $twitPosts = array();
        $fbPost = null;
        $test = null;
        $stopid = 0; $totalget = 200; $counter = 1;
        $dictfile = fopen("/var/www/html/cs309_g8_censure/config/engl_words_350k.txt", "r") or die("Unable to open file!");
        $dictarray = array();
        $postData = $data["data"];
        

        
        while (!feof($dictfile)){
        	array_push($dictarray, trim(fgets($dictfile)));
        }
        fclose($dictfile);
        $i = 0;
        do {
            foreach($postData as $fullFbPost) {
                    if ($i == 0){
                         $fbPost = new facebookPost($fullFbPost);
                    }
                    else{
                        $fbPost = new facebookPostArray($fullFbPost);
                    }
                    $test = new algorithm($fbPost, $strictness, $dictarray, $custom);
                    $test->runAlgorithm();
                    //if score is not 0 or 1, add it to $dirtyTweets
                    if($test->getScore() >= 1){
                        $fbPost->addReason($test->getReason());
                        array_push($dirtyPosts, $fbPost);
                    }
                }
                if ($i == 0){
            $url = $data["paging"]->next;
                }
                else{
                    $url = $data["paging"]['next'];
                }

            $fetched = file_get_contents($url);
            $data = json_decode($fetched, true);
            $postData = $data['data'];
            $i = $i + 1;
        } while ($postData != null);
        
        return $dirtyPosts;
    }
}


function getDirtyTumblr($cusername, $strictness, $custom) 
	{
        /*$access = getTumblrTokens($cusername);
        $client = new Tumblr\API\Client(TUMBLR_CONSUMER_KEY, TUMBLR_CONSUMER_SECRET, $access[0], $access[1]);
        $blogName = $client->getUserInfo()->user->name;
        foreach($client->getBlogInfo($blogName) as $test) {
            $total = $test->posts;
        }*/
        $dirtyTumblr = array();
        $tumblrPost = null;
        $test = null;
        $dictfile = fopen("/var/www/html/cs309_g8_censure/config/engl_words_350k.txt", "r") or die("Unable to open file!");
        $dictarray = array();
        while (!feof($dictfile)){
        	array_push($dictarray, trim(fgets($dictfile)));
        }
        fclose($dictfile);
    
        $postArray = getAllTumblrPosts($cusername);
        foreach($postArray as $postx) {
            $tumblrPost = new tumblrPost($postx);
            $test = new algorithm($tumblrPost, $strictness, $dictarray, $custom);
            $test->runAlgorithm();
            if($test->getScore() >= 1) {
                $tumblrPost->addReason($test->getReason());
                array_push($dirtyTumblr, $tumblrPost);
            }
        }
        return $dirtyTumblr;
        
        /*$gets = 20; $totes = 0;
        while($totes < $total) {
            foreach($client->getBlogPosts($blogName, array('type' => "text", 'limit'=> $gets,'offset'=> $totes))->posts as $postx) {
                $tumblrPost = new tumblrPost($postx);
                $test = new algorithm($tumblrPost, $strictness, $dictarray, $custom);
                $test->runAlgorithm();
                if($test->getScore() >= 1) {
                    $tumblrPost->addReason($test->getReason());
                    array_push($dirtyTumblr, $tumblrPost);
                }
            }
            $totes += $gets;
        }
        return $dirtyTumblr;*/
}
}

?>