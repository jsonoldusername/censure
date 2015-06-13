<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);


//session_start();
//if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	//header ("Location: login.php");
//}

//set the session variable to 1, if the user signs up. That way, they can use the site straight away
//do you want to send the user a confirmation email?
//does the user need to validate an email address, before they can use the site?
//do you want to display a message for the user that a particular username is already taken?
//test to see if the u and p are long enough
//you might also want to test if the users is already logged in. That way, they can't sign up repeatedly without closing down the browser
//other login methods - set a cookie, and read that back for every page
//collect other information: date and time of login, ip address, etc
//don't store passwords without encrypting them

$uname = "";
$pword = "";
$num_rows = 0;
$aResult = array();

/*switch($_POST['functionname']) {
	case 'signup':
	   if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
	       $aResult['error'] = 'Error in arguments!';
	   }
	   else {
	       signup($_POST['arguments'][0], $_POST['arguments'][1]);
	   }
	   break;
	
	default:
	   $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
	   break;
}*/


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$uname = $_POST['username'];
	$pword = $_POST['password'];
	signup($uname, $pword);
}

function signup($uname, $pword){
	require 'GrantTest/dbconfig.php';
	$num_rows = 0;

	//====================================================================
	//	GET THE CHOSEN U AND P, AND CHECK IT FOR DANGEROUS CHARCTERS
	//====================================================================

	$uname = htmlspecialchars($uname);
	$pword = htmlspecialchars($pword);


//test to see if $errorMessage is blank
//if it is, then we can go ahead with the rest of the code
//if it's not, we can display the error

	//====================================================================
	//	Write to the database
	//====================================================================

	//====================================================================
	//	CHECK THAT THE USERNAME IS NOT TAKEN
	//====================================================================
      $username = '"'.$connection->real_escape_string($uname).'"';
	$SQL = "SELECT username 
	        FROM UserTable 
	        WHERE username = $username";
	$result = mysqli_query($connection, $SQL);
	if ($result){
	    $num_rows = mysqli_num_rows($result);
	} else{
		//Bad database connection?
	    return;
	}

	if ($num_rows > 0) {
		//Username already taken
	    return;
	}
	
	else {//successful signup!
          $username = '"'.$connection->real_escape_string($uname).'"';
          $password = '"'.md5($connection->real_escape_string($pword)).'"';
		$SQL = "INSERT INTO UserTable (username, password) VALUES ($username, $password)";
          $result = mysqli_query($connection, $SQL);
		if (!$result){
	        //Bad database connection?
	        return;
	    }


	//=================================================================================
	//	START THE SESSION AND PUT SOMETHING INTO THE SESSION VARIABLE CALLED login
	//	SEND USER TO A DIFFERENT PAGE AFTER SIGN UP
	//=================================================================================

		session_start();
		$_SESSION['login'] = "1";
    $_SESSION['username'] = $uname;
		header ("Location: signupauth.php");

	}


}

?>