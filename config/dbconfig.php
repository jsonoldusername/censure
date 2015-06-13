<?php

define('DB_SERVER', 'mysql.cs.iastate.edu');
define('DB_USERNAME', 'u30908');
define('DB_PASSWORD', 'hnHdphbCsP');
define('DB_DATABASE', 'db30908');
$database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
?>