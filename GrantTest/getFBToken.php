<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('America/Chicago');
}
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

function getGraphObject($token){
                    FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		            $longLivedAccessToken = new AccessToken($token);
		            $session = new FacebookSession($longLivedAccessToken);
	    	        $request = new FacebookRequest($session, 'GET', '/me');
		            $graphObject = $request->execute()->getGraphObject();
		            return "https://graph.facebook.com/".$graphObject->getProperty('id')."/posts"."?"."access_token=".$longLivedAccessToken;
}

function getFeed($token){
    FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		            $longLivedAccessToken = new AccessToken($token);
		            $session = new FacebookSession($longLivedAccessToken);
   $request = new FacebookRequest(
      $session,
      'GET',
      '/me/feed'
    );
    $response = $request->execute();
    $graphObject = $response->getGraphObject()->asArray();;
    return $graphObject;
}
?>