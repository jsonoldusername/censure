<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);

require "config/dbconfig.php";

$uname = "";
$pword = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	login($uname, $pword);
}

function login($uname, $pword){
	require 'GrantTest/dbconfig.php';
	$errorMessage = "";

	//$uname = $_POST['username'];
	//$pword = $_POST['password'];

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

	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================
		if ($result) {
			if ($num_rows > 0) {
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['username'] = $uname;
				//========================================================
                //	CHECK TO SEE IF USER HAS AUTHENTICATED WITH Twitter
                //========================================================
                $database = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysql_error());
                $query = "SELECT * FROM Twitter WHERE username = $username" or die(mysql_error());
                $result = $database->query($query);
                $row = $result->fetch_row();
                if (!is_null($row)) {
                    // User is authenticated with Twitter.
                    $_SESSION['authTW']  = true;
                }
                else {
                    // User is not authenticated with Twitter. 
                    $_SESSION['authTW']  = false;
                }
                //==========================================================
                //	CHECK TO SEE IF USER HAS AUTHENTICATED WITH Facebook
                //==========================================================
                $query = "SELECT * FROM Facebook WHERE username = $username" or die(mysql_error());
                $result = $database->query($query);
                $row = $result->fetch_row();
                if (!is_null($row)) {
                    // User is authenticated with Facebook.
                    $_SESSION['authFB']  = true;
                }
                else {
                    // User is not authenticated with Facebook. 
                    $_SESSION['authFB']  = false;
                }
				header ("Location: dashboard.php");
				//==========================================================
                //	CHECK TO SEE IF USER HAS AUTHENTICATED WITH Tumblr
                //==========================================================
                $query = "SELECT * FROM Tumblr WHERE username = $username" or die(mysql_error());
                $result = $database->query($query);
                $row = $result->fetch_row();
                if (!is_null($row)) {
                    // User is authenticated with Tumblr.
                    $_SESSION['authTB']  = true;
                }
                else {
                    // User is not authenticated with Tumblr. 
                    $_SESSION['authTB']  = false;
                }
				header ("Location: dashboard.php");
			}
			else {
				session_start();
				$_SESSION['login'] = "";
				$errorMessage = $errorMessage . "username or password incorrect <BR>";
			}	
		}else{
			$errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
			$errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
		}


}

?>