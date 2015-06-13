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

FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );

$sql = "SELECT * FROM Facebook WHERE username = '10204188769820257'";
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row["token"];
		$session = new FacebookSession($row["token"]);
		$request = new FacebookRequest($session, 'GET', '/me/posts');
		$userData = $request->execute()
		  ->getGraphObject()
		  ->asArray();
			var_dump($userData);
			$graph_url = "https://graph.facebook.com/me/feed?access_token=".$row['token'];
			echo "https://graph.facebook.com/me/feed?access_token=".$row['token'];
            $feed = json_decode(file_get_contents($graph_url));
			foreach($feed->data as $data)
    {
        if($data->type == 'status' or $data->type == 'photo' or $data->type == 'video' or $data->type == 'link'){
	        if($data->status_type == 'mobile_status_update'){
                $content .= '
                <table class="container">
                    <tr>
                        <td class="profile"><img src="http://graph.facebook.com/'.$data->from->id.'/picture?type=large" alt="'.$data->from->name.'" width="90" height="90"></td>
                        <td class="text">
                            <strong>'.$data->from->name.' update status</strong><br />
                            <p>'.$data->message.'</p>
                            <a href="'.$data->actions[0]->link.'">View on Facebook</a>
                        </td>
                    </tr>
                </table>
                <div class="clean"></div>
                ';
            }
            elseif($data->status_type == 'added_photos'){
                $content .= '
                <table class="container">
                    <tr>
                        <td class="profile"><img src="http://graph.facebook.com/'.$data->from->id.'/picture?type=large" alt="'.$data->from->name.'" width="90" height="90"></td>
                        <td class="text">
                            <strong>'.$data->from->name.' added a picture</strong><br />
                            <p>'.$data->message.'</p>
                            <p><img src="'.$data->picture.'"></p>
                            <a href="'.$data->actions[0]->link.'">View on Facebook</a>
                        </td>
                    </tr>
                </table>
                <div class="clean"></div>
                ';
            }
            elseif($data->status_type == 'shared_story'){
                if($data->type == "link")
                {
                    $content .= '
                    <table class="container">
                        <tr>
                            <td class="profile"><img src="http://graph.facebook.com/'.$data->from->id.'/picture?type=large" alt="'.$data->from->name.'" width="90" height="90"></td>
                            <td class="text">
                                <strong>'.$data->from->name.' shared a link</strong><br />
                                <p>'.$data->message.'</p>
                                <table class="link">
                                    <tr>
                                        <td valign="top"><a href="'.$data->link.'"><img src="'.$data->picture.'"></a></td>
                                        <td>
                                            <p>'.$data->name.'</p>
                                            <p>'.$data->description.'</p>
                                        </td>
                                    </tr>
                                </table>
                                <a href="'.$data->actions[0]->link.'">View on Facebook</a>
                            </td>
                        </tr>
                    </table>
                    <div class="clean"></div>
                    ';   
                }
                if($data->type == "video")
                {
                    $content .= '
                    <table class="container">
                        <tr>
                            <td class="profile"><img src="http://graph.facebook.com/'.$data->from->id.'/picture?type=large" alt="'.$data->from->name.'" width="90" height="90"></td>
                            <td class="text">
                                <strong>'.$data->from->name.' shared a video</strong><br />
                                <p>'.$data->message.'</p>
                                <table class="link">
                                    <tr>
                                        <td valign="top"><a href="'.$data->link.'"><img src="'.$data->picture.'"></a></td>
                                        <td>
                                            <p>'.$data->name.'</p>
                                            <p>'.$data->description.'</p>
                                        </td>
                                    </tr>
                                </table>
                                <a href="'.$data->actions[0]->link.'">View on Facebook</a>
                            </td>
                        </tr>
                    </table>
                    <div class="clean"></div>
                    ';   
                }
            }
        }
    }

} }else {
    echo "0 results";
}
