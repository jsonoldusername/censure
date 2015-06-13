<?php
session_start();
require 'getProfilePicture.php';
include_once "twitteroauth/autoload.php";
include_once "twitter/twitteroauth.php";
include_once "config/twconfig.php";
include_once "config/functions.php";
if(isset($_SESSION['login'])) {
    if($_SESSION['login'] == false){
        header('Location: http://censureapp.com/index.php');
    }
}
$profile = getPic();
$name = $_SESSION['username'];
$auth1 = 0; $auth2 = 0; $auth3 = 0;
if(isset($_SESSION['username'])) {
    $name = $_SESSION['username'];
}
?>

<html>
	<head>
		<title>Settings</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<link rel="stylesheet" href="css/jquery-ui.css" />
		<link rel="stylesheet" href="css/skel.css" />
		<link rel="stylesheet" href="css/style.css" />
		<link rel="stylesheet" href="css/style-wide.css" />
		<link rel="stylesheet" href="css/dash.css" />
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.scrollzer.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script src="js/jquery-1.9.1.js"></script>
		<script src="js/jquery-ui.js"></script>
		</head>
<script>
$(document).ready(function() {
var piclink = "<?php echo $profile; ?>";
$("#title").text("<?php echo $name; ?>");
		    if(piclink.length > 2) {
		        $("#avatar").attr("src", piclink);
		    }
    $("#loginx").show();
    var uvalid = 0;
    $('.warning').hide();
    $("input:button").click(function(){
        if(uvalid == 1) {
            var p1 = $("#ouser").val();
            var p2 = $("#opass").val();
            //$('.warning').text("Invalid Username/Password");
            //$('.warning').show();
            $.post("change_password.php", { oldpass: p1, newpass : p2 },  
                    function(result){  
                        if(result == 0) {  
                            uvalid = 1;
                            $('input[type=text]').css({ 'color': '#ffffff', 'border-color': '#ffffff' });
                            $('.warning').css('color', 'green');
                            $('.warning').text("Password Changed");
                            $('.warning').show();
                        } else if(result == 1) {  
                            uvalid = 0;
                            $('input[type=text]').css({ 'color': 'red', 'border-color': 'red' });
                            $('.warning').text("Incorrect Old Password");
                            $('.warning').show();
                        } else {
                            uvalid = 0;
                            $('input[type=text]').css({ 'color': 'red', 'border-color': 'red' });
                            $('.warning').text("Password Change Failed");
                            $('.warning').show();
                        }
                    }); 
        }
    });
    $('input[type=password]').keyup(function() {
        $('.warning').css('color', 'red');
        var pass = $(this).val();
        if (pass.length < 8 || pass.length > 16) {
            uvalid = 0;
            $('input[type=password]').css({ 'color': 'red', 'border-color': 'red' });
            $('.warning').text("Invalid Password Length");
            $('.warning').show();
        } else {
            uvalid = 1;
            $('input[type=password]').css({ 'color': '#222629', 'border-color': '#222629' });
            $('.warning').hide();
        }
    }).blur(function() {
        $('input[type=password]').css({ 'color': '#222629', 'border-color': '#222629' });
        $('.warning').hide();
    });
});
</script>
<style>
    		.bttn:hover p.pl:after {
    		    padding-top: 2px;
    		}
    		.bttn span {
    		    padding-top: 2px;
    		}
    		#main > section {
    		    padding: 1em;
    		}
    		#nav ul li a.active span:before {
                color: #3498db;
            }
            #skel-layers-hiddenWrapper {
                display: none;
            }
            #footer {
                height: 60%;
            }
            #outer {
              width: 100%;
              text-align: center;
            }
            
            #inner {
              display: inline-block;
            }
            .bttn {
                cursor: pointer;
                float: none;
                text-transform: uppercase;
                letter-spacing: 2px;
                text-align: center;
                color: #0C5;
                font-size: 24px;
                font-family: "Nunito", sans-serif;
                font-weight: 300;
                width: 220px;
                height: 42px;
                background: #3498db;
                color: #FFF;
                overflow: hidden;
                transition: all 0.5s;
                border-radius: 5px; 
                -moz-border-radius: 5px; 
                -webkit-border-radius: 5px; 
                display:inline-block;
            }
            .bttn:hover, .bttn:active {
                text-decoration: none;
                color: #3498db;
                border-color: #3498db;
                background: #FFF;
                transition: all 0.5s;
            }
            .bttn span {
                display: inline-block;
                position: relative;
                width: 100%;
                transition: all 0.5s;
                vertical-align: middle;
            }
            .bttn:hover span {
                display:none;
                transition: all 0.5s;
                vertical-align: middle;
            }
            .titlex {
                line-height: 1em;
                width:100%;
                text-align:center;
                color:#222629;
                font-size: 40px;
                font-family: "Nunito", sans-serif;
                text-transform: uppercase;
                letter-spacing: 2px;
            }
            .pr, .pl {
                margin: 0px;
            }
            .login{
            	height: 150px;
            	width: 100%;
            	padding: 10px;
            	z-index: 2;
            	transition: all 0.5s;
            }
            
            #loginx {
                display: none;
            }
            .login input[type=password]{
            	width: 250px;
            	height: 30px;
            	background: transparent;
            	border: 1px solid #222629;
            	border-radius: 2px;
            	color: #fff;
            	font-family: 'Nunito', sans-serif;
            	text-transform: uppercase;
                letter-spacing: 2px;
            	font-size: 16px;
            	font-weight: 400;
            	padding: 4px;
            	margin-top: 10px;
            }
            
            .login input[type=button]{
            	cursor: pointer;
            	padding: 0px;
            	margin-bottom: 30px;
            	float: none;
                text-transform: uppercase;
                letter-spacing: 2px;
                text-align: center;
                color: #0C5;
                font-size: 24px;
                font-family: "Nunito", sans-serif;
                font-weight: 300;
                width: 300px;
                height: 42px;
                background: #3498db;
                color: #FFF;
                overflow: hidden;
                transition: all 0.5s;
                border-radius: 5px; 
                -moz-border-radius: 5px; 
                -webkit-border-radius: 5px; 
            }
            
            .login input[type=button]:hover{
            	text-decoration: none;
                color: #3498db !important;
                border-color: #3498db;
                background: #FFF;
                transition: all 0.5s;
            }
            
            .login input[type=button]:active{
            	text-decoration: none;
                color: #3498db !important;
                border-color: #3498db;
                background: #FFF;
                transition: all 0.5s;
            }
            
            .login input[type=text]:focus{
            	outline: none;
            }
            
            .login input[type=password]:focus{
            	outline: none;
            }
            
            .login input[type=button]:focus{
            	outline: none;
            }
            
            ::-webkit-input-placeholder{
               color: #222629;
            }
            
            ::-moz-input-placeholder{
               color: #222629;
            }
            
            .warning {
                text-align:center;
                width:100%;
                display:block;
                margin-right: -10px;
                color: red;
                font-size: 13px;
                margin-top:0px;
                margin-bottom:-10px;
                font-family: "Nunito", sans-serif;
                text-transform: uppercase;
            }
		</style>
<body>
			<div id="header" class="skel-layers-fixed">
				<div class="top">
						<div id="logo">
							<span class="image avatar48" style="float:left;"><img id="avatar" src="images/censure.png" alt="" height="42" width="42"/></span>
							<h1 id="title">Censure</h1>
							<p>Nice to see you!</p>
						</div>    
						<nav id="nav">
							<!--
							
								Prologue's nav expects links in one of two formats:
								
								1. Hash link (scrolls to a different section within the page)
								
								   <li><a href="#foobar" id="foobar-link" class="icon fa-whatever-icon-you-want skel-layers-ignoreHref"><span class="label">Foobar</span></a></li>

								2. Standard link (sends the user to another page/site)

								   <li><a href="http://foobar.tld" id="foobar-link" class="icon fa-whatever-icon-you-want"><span class="label">Foobar</span></a></li>
							
							-->
							<ul>
								<li><a href="http://censureapp.com/dashboard.php" id="dashboard-link" class="skel-layers-ignoreHref"><span class="icon fa-dashboard">Dashboard</span></a></li>
								<li><a href="http://censureapp.com/signupauth.php" id="social-link" class="skel-layers-ignoreHref"><span class="icon fa-th">Accounts</span></a></li>
								<li><a href="#settings" id="contact-link" class="skel-layers-ignoreHref scrollzer-locked active"><span class="icon fa-envelope">Settings</span></a></li>
							    <li><a href="http://censureapp.com/logout.php" id="logout-link" class="skel-layers-ignoreHref"><span class="icon fa-power-off">Logout</span></a></li>
							</ul>
						</nav>
				</div>
			</div>

		<!-- Main -->
	<div id="main">
	<section id="dashboard" class="three">
    <div class="titlex">Change Your Password</div>
        <div id="loginx" class="login">
				<input type="password" placeholder="Current Password" name="user" id="ouser"><br>
				<input type="password" placeholder="New Password" name="password" id="opass"><br>
                    <div class="warning">Invalid New Password</div>
		            <input type="button" value="Change" style="margin-top:10px;" id="submission"><br>
	            </div>
        </div>
        </section>
        </div>
        <div id="footer" style="height: 70%;">
					<ul class="copyright">
						<li>&copy; Censure. All rights reserved.</li>
					</ul>
			</div>
			</body>
    <FORM NAME ="form1" METHOD ="POST" ACTION ="" id="target" style="display:none;width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'TEXT' Name ='username'  value="<?PHP print $uname;?>" id="suser" style="width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'TEXT' Name ='password'  value="<?PHP print $pword;?>" id="spass" style="width:0px;height:0px;padding:0px;">
        <INPUT TYPE = 'SUBMIT' Name = "Submit1"  VALUE = "" id="submitter" style="width:0px;height:0px;padding:0px;">
    </FORM>

</html>