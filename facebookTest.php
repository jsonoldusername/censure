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



