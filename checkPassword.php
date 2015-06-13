<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
require 'GrantTest/dbconfig.php';

$uname = $_POST['username'];
$pword = $_POST['password'];

$uname = htmlspecialchars($uname);
$pword = htmlspecialchars($pword);
		
$username = '"'.$connection->real_escape_string($uname).'"';
$password = '"'.md5($connection->real_escape_string($pword)).'"';

$SQL = "SELECT * 
				FROM UserTable 
				WHERE username = $username AND
				password = $password";

$result = mysqli_query($connection, $SQL);
if ($result){
	$num_rows = mysqli_num_rows($result);
} else{
	$errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
	$errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
}

if ($num_rows > 0) {
	echo 1;
} else {
	echo 0;
}


?>