<?php
//Always place this code at the top of the Page
session_start();
$_SESSION['login'] = "";
?>

<html>
<head>
<title>Login or Signup</title>
</head>
<body>

<!--<FORM NAME ="form1" METHOD ="POST" ACTION ="front_page.php">

<P align = center>-->
<button onclick="location.href = 'http://censureapp.com/signup.php';" id="signupButton" class="float-left submit-button" >Signup</button>
<button onclick="location.href = 'http://censureapp.com/login.php';" id="loginButton" class="float-left submit-button" >Login</button>

<!--<INPUT TYPE = "Submit" Name = "Signup_submit"  VALUE = "New User Signup">
<INPUT TYPE = "Submit" Name = "Login_submit"  VALUE = "Returning User Login">-->
<!--</P>

</FORM>

<P>-->




</body>
</html>