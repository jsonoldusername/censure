<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

function change_password($username, $old_password, $new_password){
    require dirname(__FILE__).'/../GrantTest/dbconfig.php';;
    $errorMessage = "";

    $username = htmlspecialchars($username);
	$old_password = htmlspecialchars($old_password);
	$new_password = htmlspecialchars($new_password);

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
			if ($result = mysqli_query($connection, $SQL)) return "Successfully changed password!";
			else return "Update failed.";
		} else{
		    return "Incorrect username or password.";
		}
	} else{
	    return mysqli_error($connection) . "<BR>" . "Query: " . $SQL . "<BR>";
	}
}

echo(change_password("aeforest_", "password", "password1"));
?>