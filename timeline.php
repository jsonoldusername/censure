<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

//Always place this code at the top of the Page
session_start();
require_once 'autoload.php';
require_once('facebook/FacebookSession.php');
require_once('facebook/FacebookRedirectLoginHelper.php');
require_once('facebook/FacebookRequest.php');
require_once('facebook/FacebookResponse.php');
require_once('facebook/FacebookSDKException.php');
require_once('facebook/FacebookRequestException.php');
require_once('facebook/FacebookAuthorizationException.php');
require_once('facebook/GraphObject.php');
require_once('facebook/Entities/AccessToken.php');
require_once('facebook/HttpClients/FacebookCurl.php');
require_once('facebook/HttpClients/FacebookHttpable.php');
require_once('facebook/HttpClients/FacebookCurlHttpClient.php');
require 'GrantTest/dbconfig.php';

use facebook\FacebookSession;
use facebook\FacebookRedirectLoginHelper;
use facebook\FacebookRequest;
use facebook\FacebookResponse;
use facebook\FacebookSDKException;
use facebook\FacebookRequestException;
use facebook\FacebookAuthorizationException;
use facebook\GraphObject;
use facebook\Entities\AccessToken;
use facebook\HttpClients\FacebookCurl;
use facebook\HttpClients\FacebookHttpable;
use facebook\HttpClients\FacebookCurlHttpClient;


require 'config/twconfig.php';
require "twitteroauth/autoload.php";
require_once('algorithm.php');
use Abraham\TwitterOAuth\TwitterOAuth;

//======================================Twitter======================================

$request_token = [];
$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
//TODO 
//Add database query to get tokens from database. See Jason's test to see an example.

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    // Abort! Something is wrong.
}
$connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
$_SESSION['access_token'] = $access_token;
$connection = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$user = $connection->get("account/verify_credentials");

//POST status
//$statuses = $connection->post("statuses/update", array("status" => "hello world"));
//var_dump($statuses);

/*if ($connection->getLastHttpCode() == 200) {
    echo "yay"."<br />";
} else {
    echo "no"."<br />";
}*/
$timeline = $connection->get("statuses/user_timeline");
$counter = 1;
foreach($timeline as $tweet){
    echo "Tweet ". $counter.": \"".$tweet->text."\"->"."id: ".$tweet->id."<br />";
    $counter = $counter + 1;
}
    
//======================================Facebook======================================    
  
    $SQL = "SELECT username, user_key, token 
		        FROM Facebook 
		        WHERE username = " .$_SESSION['username'];
		$result = mysqli_query($connection, $SQL);
		if ($result){
		    $num_rows = mysqli_num_rows($result);
		} else{
		    $errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
		    $errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
		}

		if ($num_rows > 0) {
		     while($row = $result->fetch_assoc()) {
		         FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		         $longLivedAccessToken = new AccessToken($row["token"]);
		         $session = new FacebookSession($longLivedAccessToken);
	    	$request = new FacebookRequest($session, 'GET', '/me');
		    $graphObject = $request->execute()
		      ->getGraphObject();
		      
     	    $fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	        $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	          $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
            }
		}
?>

<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
<div class="container">
<div class="span4">
 <ul class="nav nav-list">

		      <div class="hero-unit">
  <h1>Hello <?php echo $fbfullname; ?></h1>
  </div>
<div class="span4">
 <ul class="nav nav-list">
<li class="nav-header">Image</li>
	<li><img src="https://graph.facebook.com/<?php echo $fbid; ?>/picture"></li>
<li class="nav-header">Facebook ID</li>
<li><?php echo $fbid; ?></li>
<li class="nav-header">Facebook fullname</li>
<li><?php echo  $fbfullname; ?></li>
<li class="nav-header">Facebook Email</li>
<li><?php echo $femail; ?></li>
</ul></div></div>
  </body>
</html>




