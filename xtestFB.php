<?php
//Always place this code at the top of the Page
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'config/functions.php';

$user = new User();

$strict = $_POST['param1'];
$custom = $_POST['param2'];
if(is_null($_SESSION['username'])){
    $dirtyPosts = $user->getDirtyFacebook("Censure309", $strict, $custom);
} else{
    // if censure user exists. Have to add logic later to ensure a Twitter account exists.
    $dirtyPosts = $user->getDirtyFacebook($_SESSION['username'], $strict, $custom);
}
$counter = 1;
if (count($dirtyPosts) != 0){
echo "<br />";
echo('<div style="color: red;">We recommend removing the following posts: </div>');
echo "<br />";
foreach($dirtyPosts as $fbPost ) {
    echo "<div class=\"delete\"id=".$fbPost->identifier."> </div><div id=".$fbPost->identifier."t class=tweeter>".$fbPost->text."<br/>";
    echo " ".$fbPost->date['month']."/".$fbPost->date['day']."/".$fbPost->date['year']." ".$fbPost->date['hour'].":".$fbPost->date['minute'].":".$fbPost->date['second']."<br />".$fbPost->reason."</div>"."<br />"."<br />";
    $counter++;
}
}
else {
    echo "Looks like your posts are okay!";
}

?>