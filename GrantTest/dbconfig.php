<?php
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');    // DB username
define('DB_PASSWORD', 'censureapp!mysql');    // DB password
define('DB_DATABASE', 'censure');      // DB name
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
?>
