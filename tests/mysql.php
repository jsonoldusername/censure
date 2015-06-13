<?php

$user = 'u30908';
$pass = 'hnHdphbCsP';
$db = 'db30908';

$conn = new mysqli('mysql.cs.iastate.edu', $user, $pass, $db) or die('Unable');

echo'success';

$sql = "SELECT username FROM Facebook";
$result = $conn->query($sql);
$row = mysqli_fetch_assoc($result);

echo $row["username"];

$conn->close();

?>