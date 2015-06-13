<?php
session_start();

$username = htmlspecialchars($_SESSION['username']);
$old_password = htmlspecialchars($_POST['oldpass']);
$new_password = htmlspecialchars($_POST['newpass']);

require 'GrantTest/dbconfig.php';
$errorMessage = "";


$username = '"'.$connection->real_escape_string($username).'"';
$old_password = '"'.md5($connection->real_escape_string($old_password)).'"';
$new_password = '"'.md5($connection->real_escape_string($new_password)).'"';

$SQL = "SELECT * 
	    FROM UserTable 
		WHERE username = $username AND
		password = $old_password";
$result = mysqli_query($connection, $SQL);

if ($result){
	$num_rows = mysqli_num_rows($result);
	if ($num_rows > 0) {
		$SQL = "UPDATE UserTable
		    SET password = $new_password
		    WHERE username = $username AND
		    password = $old_password";
		if ($result = mysqli_query($connection, $SQL)) echo 0;
		else echo 2;
	} else{
	    echo 1;
	}
} else{
    return mysqli_error($connection) . "<BR>" . "Query: " . $SQL . "<BR>";
}

?>