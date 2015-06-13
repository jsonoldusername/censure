<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require '../config/dbconfig.php';
    $uid = '242598535';
    
    $database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
    $query = "SELECT * FROM Twitter WHERE uid = '$uid'" or die(mysql_error());
    $result = $database->query($query);
    $row = $result->fetch_row();
    var_dump($row);
    
    if (!is_null($row)) {
        # User is already present
        $twitter_otoken_secret =$row[5];
        $twitter_otoken = $row[6]; 
        $token_array = array($twitter_otoken_secret, $twitter_otoken);
        var_dump($token_array);
    } else {
        #user not present. Return null
        
    }
    
?>

