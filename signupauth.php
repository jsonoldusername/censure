<!DOCTYPE HTML>

<?php
session_start();
$validTW = 0;
$validFB = 0;
$validTB = 0;
if($_SESSION['authTW'] == true) {
    $validTW = 1;
}
if($_SESSION['authFB'] == true) {
    $validFB = 1;
}
if($_SESSION['authTB'] == true) {
    $validTB = 1;
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
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
		<style>
		.bttn:hover p.pl:after {
            content:"Of Course I Did!";
        }
        .bttn {
            width: 60%;
            height: 100%;
        }
        .ic {
            cursor: pointer;
            margin-left: 10px;
            margin-right: 10px;
            overflow:hidden;
            z-index: 1;
            width: 100px;
            height: 100px;
            -webkit-border-radius: 100px;
            -moz-border-radius: 100px;
            border-radius: 100px;
        }
        .soc {
            overflow:hidden;
            margin:0;
            padding:0;
            list-style:none;
            background-color: #222629;
            padding-top: 30px;
        }
        .soc li {
            display:inline-block;
            display:inline;
            zoom:1;
            z-index: 2;
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }
		</style>
		<script>
		$(document).ready(function() {
		    var authTW = <?php echo $validTW; ?>;
		    var authFB = <?php echo $validFB; ?>;
		    var authTB = <?php echo $validTB; ?>;
		    $('.warning').hide();
		    if(authTW < 1 && authFB < 1 && authTB < 1) {
		        $('.link').attr("href", "#");
		    }
		    if (authTW  == 1){
		    document.getElementById("twt").style.opacity = '0.2';;
             }  
		    if (authFB == 1){
		     document.getElementById("fb").style.opacity = '0.2';
		    }
		    if (authTB == 1){
		     document.getElementById("tb").style.opacity = '0.2';
		    }
		    $('.bttn').click(function(){
		        if(authTW < 1 && authFB < 1 && authTB < 1) {
		            $('.warning').show();
		        }
		    });
		    if (!authTW ){
                $("#twt").hover(function() {
                    //animation
                });
                $("#twt").click(function() {
                window.location = 'RequestTwitterAuth.php';
                });
		    }
            if (!authFB ){
                $("#fb").hover(function() {
                    //animation
                });
                $("#fb").click(function() {
                    window.location = 'GrantTest/fbconfig.php';
                });
            }
            if (!authTB ){
                $("#tb").hover(function() {
                    //animation
                });
                $("#tb").click(function() {
                    window.location = 'tumblr.php/tumblrauth.php';
                });
            }
        });
        </script>
    </head>
<div class="main">
    <div class="title">Add Your Social Networks</div>
</div>
<ul class="soc">
    <li><img src="images/twittera.png" id="twt" class="ic"></li>
    <li><img src="images/facebooka.png" id="fb" class="ic"></li>
    <li><img src="images/tumblra.png" id="tb" class="ic"></li>
</ul>
<div style="background-color: #222629; padding-top:10px;">
    <div class="warning">LIAR!</div>
    <div class="bttn" style="color:#ffffff;">
    <a class="link" href ="dashboard.php">
        <p id="left" class="pl">
            <span>Did You Connect At Least One Social Network?</span>
        </p>
    </a>
    </div>
</div>
</html>