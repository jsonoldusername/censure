<?php

$user = 'u30908';
$pass = 'hnHdphbCsP';
$db = 'db30908';

$conn = new mysqli('mysql.cs.iastate.edu', $user, $pass, $db) or die('Unable');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO Twitter (uid, oauth_provider, username, email, token_secret, token)
VALUES ('80808080', 'Twitter', 'testUserName', 'john@example.com', 'testToken_Secret', 'testToken')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>