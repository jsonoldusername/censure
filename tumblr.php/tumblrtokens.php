<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
include_once dirname(__FILE__).'/../config/dbconfig.php';
function getTumblrTokens($username) {
    $database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
    if(preg_match("/'/", $username)) {
        $query = "SELECT * FROM Tumblr WHERE username = $username" or die(mysql_error());
    } else {
        $query = "SELECT * FROM Tumblr WHERE username = '$username'" or die(mysql_error());
    }
    $result = $database->query($query);
    if($result) {
        $row = $result->fetch_row();
        $token_array = null;
        if (!is_null($row)) {
            $token =$row[1];
            $secret = $row[2]; 
            $token_array = array($token, $secret);
        } 
        return $token_array;
    }
}
?>