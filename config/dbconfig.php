<?php

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'censureapp!mysql');
define('DB_DATABASE', 'censure');
$database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
?>