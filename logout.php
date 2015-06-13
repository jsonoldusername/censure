<?PHP
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
session_start();
    session_unset();
    session_destroy();
    session_write_close();
    setcookie(session_name(),'',0,'/');
    session_regenerate_id(true);
		header ("Location: index.php");

?>