<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'config/functions.php';
$user = new User();
$strictness = $_POST['param1'];
$custom = $_POST['param2'];

if(isset($_SESSION['username'])){
    $uname = "'".$_SESSION['username']."'";
    $dirtyTweets = $user->getDirtyTweets($uname, $strictness, $custom);
} else {
    //ERROR
}
$counter = 1;
echo "<br />";
echo('<div style="color: red;">We recommend removing the following tweets: </div>');
echo "<br />";
foreach($dirtyTweets as $twitterPost ) {
    echo "<div class=\"delete\"id=".$twitterPost->identifier.">Delete </div><div id=".$twitterPost->identifier."t class=tweeter>".$twitterPost->text."<br/>";
    echo " ".$twitterPost->date['month']."/".$twitterPost->date['day']."/".$twitterPost->date['year']." ".$twitterPost->date['hour'].":".$twitterPost->date['minute'].":".$twitterPost->date['second']."<br />".$twitterPost->reason."</div>"."<br />"."<br />";
    $counter++;
}
?>