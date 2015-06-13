<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('America/Chicago');
}
session_start();
// added in v4.0.0
require_once 'autoload.php';
require_once( 'Facebook/FacebookSession.php');
require_once( 'Facebook/FacebookRedirectLoginHelper.php');
require_once( 'Facebook/FacebookRequest.php');
require_once( 'Facebook/FacebookResponse.php');
require_once( 'Facebook/FacebookSDKException.php');
require_once( 'Facebook/FacebookRequestException.php');
require_once( 'Facebook/FacebookAuthorizationException.php');
require_once( 'Facebook/GraphObject.php');
require_once( 'Facebook/Entities/AccessToken.php');
require_once( 'Facebook/HttpClients/FacebookCurl.php' );
require_once( 'Facebook/HttpClients/FacebookHttpable.php');
require_once( 'Facebook/HttpClients/FacebookCurlHttpClient.php');
require 'dbconfig.php';

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurlHttpClient;


// init app with app id and secret
FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
// login helper with redirect_uri
  $helper = new FacebookRedirectLoginHelper('http://proj-309-08.cs.iastate.edu/cs309_g8_censure/GrantTest/fbconfig.php' );
    //$scope = array('user_posts');
    //$loginUrl = $helper->getLoginUrl($scope);


try {
  $session = $helper->getSessionFromRedirect();
} catch( FacebookRequestException $ex ) {
  // When Facebook returns an error
} catch( Exception $ex ) {
  // When validation fails or other local issues
}
// see if we have a session
if ( isset( $session ) ) {
    // User logged in, get the AccessToken entity.
  $accessToken = $session->getAccessToken();
  // Exchange the short-lived token for a long-lived token.
  $longLivedAccessToken = $accessToken->extend();

  // graph api request for user data
  $request = new FacebookRequest( $session, 'GET', '/me' );
  $response = $request->execute();
  // get response
  $graphObject = $response->getGraphObject();
     	$fbid = $graphObject->getProperty('id');              // To Get Facebook ID
 	    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
	    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID
	/* ---- Session Variables -----*/
	    $_SESSION['FBID'] = $fbid;           
        $_SESSION['FULLNAME'] = $fbfullname;
	    $_SESSION['EMAIL'] =  $femail;
	 

//values to be inserted in database table
$username = '"'.$connection->real_escape_string($_SESSION['username']).'"';
$key = '"'.$connection->real_escape_string('NA').'"';
$token = '"'.$connection->real_escape_string($longLivedAccessToken).'"';
	//====================================================================
	//	CHECK THAT THE USERNAME ISN'T ALREADY IN DATABASE
	//====================================================================
	//original sql
		//$SQL = "SELECT username 
		        //FROM Facebook 
		        //WHERE username = " .$_SESSION['username'];
		$uname = "'".$_SESSION['username']."'";
		$SQL = "SELECT username FROM Facebook WHERE username = $uname";
		$result = mysqli_query($connection, $SQL);
		if ($result){
		    $num_rows = mysqli_num_rows($result);
		} else{
		    $errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
		    $errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
		}

		if ($num_rows > 0) {
			$errorMessage = $errorMessage . "Username already registered <BR>";
			 $_SESSION['facebooklogin'] = true;
		}
		
		else {
		    //original query
            //$query = "INSERT INTO Facebook (username, user_key, token) VALUES(". $_SESSION['username'] .", $key, $token)";
            $query = "INSERT INTO Facebook (username, user_key, token) VALUES($username, $key, $token)";
            if (mysqli_query($connection, $query)) {
                echo "Successfully inserted " . mysqli_affected_rows($connection) . " row";
                 $_SESSION['authFB'] = 1;
            } else {
                die("Error occurred: " . mysqli_error($connection));
            }
		    }




    $connection->close();
    /* ---- header location after session ----*/
     $_SESSION['authFB'] = true;
     if($_SESSION['fbprofile']) {
         if($_SESSION['fbprofile'] != true) {
             header("Location: ../signupauth.php");
         }
     } else {
         header("Location: ../signupauth.php");
     }
} 
else {
  $loginUrl = $helper->getLoginUrl(array( 'user_posts', 'public_profile' , 'email' , 'user_friends' ));
 header("Location: ".$loginUrl);
}

function getFBPic($token){
     /*$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
    $username = "'".$_SESSION['username']."'";
    $SQL = "SELECT * FROM Facebook WHERE username = $username";
    $result = mysqli_query($connection, $SQL);
    if ($result) {
    	$num_rows = mysqli_num_rows($result);
        if ($num_rows > 0) {
            while($row = $result->fetch_assoc()) {
		        FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		        $longLivedAccessToken = new AccessToken($row["token"]);
		        $session = new FacebookSession($longLivedAccessToken);
	    	    $request = new FacebookRequest($session, 'GET', '/me');
		        $graphObject = $request->execute()->getGraphObject();
		        return "https://graph.facebook.com/".$graphObject->getProperty('id')."/picture"; 
}
}
}*/
                    FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		            $longLivedAccessToken = new AccessToken($token);
		            $session = new FacebookSession($longLivedAccessToken);
	    	        $request = new FacebookRequest($session, 'GET', '/me');
		            $graphObject = $request->execute()->getGraphObject();
		            return "https://graph.facebook.com/".$graphObject->getProperty('id')."/picture";
}
?>