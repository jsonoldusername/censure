<!DOCTYPE HTML>

<?php
session_start();
if($_SESSION['login'] == true){
    header ("Location: dashboard.php");
}
?>


<html style="background-color: #222629;">
	<head>
		<title>Censure</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<style>
		@import url(http://fonts.googleapis.com/css?family=Nunito:400,700,300);
		</style>
		<link rel="stylesheet" type="text/css" href="css/front.css">
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.scrollzer.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src="js/prefixfree.min.js"></script>
		<script src="js/front.js"></script>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
</head>
<div class="main">
    <div class="title">Welcome to Censure</div>
        <div class="title" style="padding-top: 0px;">Are you new here?</div>
            <div class="lhalf">
                <div class="bttn">
                    <p id="left" class="pl"><span>Yup</span></p>
                </div>
            </div>
        <div class="rhalf">
            <div class="bttn">
                <p id="right" class="pr"><span>Nah</span></p>
            </div>
        </div>
        <div id="loginx" class="login">
				<input type="text" placeholder="username" name="user" id="ouser"><br>
				<input type="password" placeholder="password" name="password" id="opass"><br>
				    <div id="tos" style="text-align:center; margin-bottom:-15px;">
				        <div class="rowone">
				            <div class="roundedOne">
	                            <input type="checkbox" value="None" id="roundedOne" name="check" />
	                            <label for="roundedOne"></label>
                            </div>
                            <div class="checkhold">I read the TOS</div>
                        </div>
                    </div>
                    <div class="warning">Your Username and Password Suck</div>
		            <input type="button" value="Start" style="margin-top:10px;" id="submission">
	            </div>
        </div>
    <FORM NAME ="form1" METHOD ="POST" ACTION ="" id="target" style="display:none;width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" id="suser" style="width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'TEXT' Name ='password'  value="<?PHP print $pword;?>" id="spass" style="width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'SUBMIT' Name = "Submit1"  VALUE = "" id="submitter" style="width:0px;height:0px;padding:0px;">
    </FORM>
</html>