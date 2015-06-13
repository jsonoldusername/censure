<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require '../config/twconfig.php';
require '../config/dbconfig.php';
require 'twitteroauth.php';
session_start();
$twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET);
// Requesting authentication tokens, the parameter is the URL we will be redirected to
$request_token = $twitteroauth->getRequestToken('http://proj-309-08.cs.iastate.edu/cs309_g8_censure/twitter/getTwitterData.php');

// Saving them into the session

$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
// If everything goes well..
if ($twitteroauth->http_code == 200) {
    // Let's generate the URL and redirect
    $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
    /***********SQL Query Start**********/
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        
        $sql = "INSERT INTO Twitter (uid, oauth_provider, username, email, 
                token_secret, token)
                VALUES ('id_placeholder', 'twitter', 'username_placeholder', 'email', 
                        $request_token['oauth_token_secret'], $request_token['oauth_token'])";
        //make query, store values in the database.
        $conn->query($sql);
        
        /*if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }*/
        
        $conn->close();
    /***********SQL Query End**********/
    
    header('Location: ' . $url);
} else {
    // It's a bad idea to kill the script, but we've got to know when there's an error.
    die('Something wrong happened.');
}
?>