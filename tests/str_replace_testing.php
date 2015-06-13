<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

include '../tumblr.php/tumblrposts.php';
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');

/*$post = "Hello\n\nworld";
$post = $connection->real_escape_string($post);
echo $post . '<BR>';
$post = str_replace('\n', ' ', $post);
echo $post;

echo "<BR>";
echo "<BR>";*/

$posts = getAllTumblrPosts('aeforest_');
foreach($posts as $post){
    echo $connection->real_escape_string($post->body);
    echo "<BR>";
    echo "<BR>";
    
}

?>