<?php
session_start();
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'config/functions.php';

function cmp($a, $b) {
    $timea = time() - strtotime($a->date_raw);
    $timeb = time() - strtotime($b->date_raw);
    if($timea == $timeb) {
        return 0;
    }
    return ($timea < $timeb) ? -1 : 1;
}

function printFacebook($facebookPost) {
    echo "<div id=".$facebookPost->identifier." class=\"master\"><div class=\"containerx\"><img class=\"postimage\" src=\"images/facebooksquare.png\">
    <div class=\"holder\"><div class=\"name\"></div><div class=\"user\">".$facebookPost->username."</div>
    <div class=\"line\"><span id=\"ic\" class=\"icon fa-calendar\" style=\"color: #3498db;\"></span><div class=\"date\">".$facebookPost->date_pretty."</div><span id=\"ic\" class=\"icon fa-comment\" style=\"color: #228B22;\"></span><div class=\"retweets\">".$facebookPost->share_equivalent."</div><span id=\"ic\" class=\"icon fa-thumbs-up\" style=\"color: #D6D633;\" ></span><div class=\"favorites\">".$facebookPost->like_equivalent."</div><a href=".$facebookPost->url."><span id=\"ic\" class=\"icon fa-link\" style=\"color: #CC33FF;\"></span></a></div>
    <div class=\"text\">".$facebookPost->text.
    "<br><img class=\"fbPicture\" src=$facebookPost->picture></div></div></div><a target=\"_blank\" href=".$facebookPost->url."><img id=".$facebookPost->identifier." class=\"deletex\" src=\"images/trash.png\"></a><div class=\"reason\" id=\"reason".$facebookPost->identifier."\">".$facebookPost->reason."</div></div>";
}

function printTwitter($twitterPost) {
    echo "<div id=".$twitterPost->identifier." class=\"master\"><div class=\"containerx\"><img class=\"postimage\" src=\"images/twittersquare.png\">
    <div class=\"holder\"><div class=\"user\">@".$twitterPost->username."</div><div class=\"line\"><span id=\"ic\" class=\"icon fa-calendar\" style=\"color: #3498db;\"></span><div class=\"date\">".$twitterPost->date_pretty."</div><span id=\"ic\" class=\"icon fa-refresh\" style=\"color: #228B22;\"></span><div class=\"retweets\">".$twitterPost->share_equivalent."</div><span id=\"ic\" class=\"icon fa-star\" style=\"color: #D6D633;\" ></span><div class=\"favorites\">".$twitterPost->like_equivalent."</div><a target=\"_blank\" href="."http://twitter.com/".$twitterPost->username."/status/".$twitterPost->identifier."><span id=\"ic\" class=\"icon fa-link\" style=\"color: #CC33FF;\"></span></a></div><div class=\"text\">".$twitterPost->text.
    "<div class=\"tumbcontainer\">".$twitterPost->mediacode."</div>".
    "</div></div></div><img id=".$twitterPost->identifier." class=\"deletex\" src=\"images/trash.png\"><div class=\"reason\" id=\"reason".$twitterPost->identifier."\">".$twitterPost->reason."</div></div>";
}

function printTumblr($tumblrPost) {
    echo "<div id=".$tumblrPost->identifier." class=\"master\"><div class=\"containerx\"><img class=\"postimage\" src=\"images/tumblrsquare.png\">
    <div class=\"holder\"><div class=\"name\"></div><div class=\"user\">".$tumblrPost->username."tumblr.com</div>
    <div class=\"line\"><span id=\"ic\" class=\"icon fa-calendar\" style=\"color: #3498db;\"></span><div class=\"date\">".$tumblrPost->date_pretty."</div><span id=\"ic\" class=\"icon fa-pencil-square\" style=\"color: #D6D633;\" ></span><div class=\"favorites\">".$tumblrPost->like_equivalent."</div><a target=\"_blank\" href="."http://".$tumblrPost->username.".tumblr.com/post/".$tumblrPost->identifier."><span id=\"ic\" class=\"icon fa-link\" style=\"color: #CC33FF;\"></span></a></div>
    <div class=\"text\">".$tumblrPost->text."<br><div class=\"tumbcontainer\">".$tumblrPost->images."</div>".
    "</div></div></div><img id=".$tumblrPost->identifier." class=\"deletex\" src=\"images/trash.png\"><div class=\"reason\" id=\"reason".$tumblrPost->identifier."\">".$tumblrPost->reason."</div></div>";
}

$user = new User();
$strictness = $_POST['param1'];
$custom = $_POST['param2'];
$fbSwitch = $_POST['param3'];
$twSwitch = $_POST['param4'];
$tbSwitch = $_POST['param5'];
$allPosts = array();
$fbPosts = array();
$twPosts = array();
$tbPosts = array();
if(isset($_SESSION['username'])) {
    $uname = "'".$_SESSION['username']."'";
    if($fbSwitch < 1) {
        $fbPosts = $user->getDirtyFacebook($uname, $strictness, $custom);
        foreach($fbPosts as $post) array_push($allPosts, $post);
    }
    if($twSwitch < 1) {
        $twPosts = $user->getDirtyTweets($uname, $strictness, $custom);
        foreach($twPosts as $post) array_push($allPosts, $post);
    }
    if($tbSwitch < 1) {
        $tbPosts = $user->getDirtyTumblr($uname, $strictness, $custom);
        foreach($tbPosts as $post) array_push($allPosts, $post);
   }
}
usort($allPosts, "cmp");

foreach($allPosts as $post) {
    if($post->getClass() == "facebookPost" || $post->getClass() == "facebookPostArray") {
        printFacebook($post);
    } else if($post->getClass() == "twitterPost") {
        printTwitter($post);
    } else if($post->getClass() == "tumblrPost") {
        printTumblr($post);
    } else {
        echo "NO CLASS TYPE IDENTIFIED";
    }
}
?>