<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
        require 'GrantTest/dbconfig.php';
        $uname = $_POST['username'];
        $username = '"'.$connection->real_escape_string($uname).'"';
		$SQL = "SELECT username 
		        FROM UserTable 
		        WHERE username = $username";
		$result = mysqli_query($connection, $SQL);
		if ($result){
		    $num_rows = mysqli_num_rows($result);
		} else{
		    $errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
		    $errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
		}

		if ($num_rows > 0) {
			echo 0;
		} else {
		    echo 1;
		}
		

?>