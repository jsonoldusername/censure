<?php
define('DB_SERVER', 'mysql.cs.iastate.edu');
define('DB_USERNAME', 'u30908');    // DB username
define('DB_PASSWORD', 'hnHdphbCsP');    // DB password
define('DB_DATABASE', 'db30908');      // DB name
$connection = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die('Unable');
?>