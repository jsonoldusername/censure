<?php
session_start();
if(isset($_SESSION['login'])) {
    if($_SESSION['login'] == false){
        header('Location: http://proj-309-08.cs.iastate.edu/cs309_g8_censure/index.php');
    }
}
require 'getProfilePicture.php';
include_once "twitteroauth/autoload.php";
include_once "twitter/twitteroauth.php";
include_once "config/twconfig.php";
include_once "config/functions.php";

$profile = getPic();
$name = $_SESSION['username'];
$auth1 = 0; $auth2 = 0; $auth3 = 0;
if(isset($_SESSION['username'])) {
    $name = $_SESSION['username'];
}
if(isset($_SESSION['authTW'])) {
    if($_SESSION['authTW'] == true) {
        $auth1 = 1;
    }
}
if(isset($_SESSION['authFB'])) {
    if($_SESSION['authFB'] == true) {
        $auth2 = 1;
    }
}
if(isset($_SESSION['authTB'])) {
    if($_SESSION['authTB'] == true) {
        $auth3 = 1;
    }
}
?>
<html>
	<head>
		<title>Dashboard</title>
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
		<script>
		$(document).ready(function() {
		$("#loader").hide();
		var tweetid = "";
        $('#appendto').on("click", '.deletex', function() {
		tweetid = $(this).attr('id');
		var tyes = 0;
		if(tweetid > 999999999999) {
		    console.log("tw");
		    tyes = 1;
		}
		    $.post("deleteTweet.php", { param1 : tweetid, param2 : tyes }).done(function( data ) {
        		var hided = "#" + tweetid;
        		var hidet = hided + "t";
        		$(hided).remove();
        		$(hidet).remove();
            });
		});
		$('.link').click(function() {
		    $("#appendto").html("");
            $("#postcontainer").hide();
            $("#loader").show();
            var strictvalue = $("#amount").val();
            var strictinput = $("#strictx").val();
            $.post("getPosts.php", { param1 : strictvalue , param2 : strictinput , param3 : fbSwitch , param4 : twSwitch , param5 : tbSwitch }).done(function( data ) {
                $("#appendto").append(data);
                $("#loader").hide();
                $("#postcontainer").show();
                $('.reason').hide();
                var hoverid = "";
	            $('#appendto').hover(function() {
	                $('.master').hover(function() {
		                hoverid = "#reason" + $(this).attr('id');
		                $(hoverid).show();
	                }, function() {
		                hoverid = "#reason" + $(this).attr('id');
		                $(hoverid).hide();
	                });
		        });
            });
        });
		var piclink = "<?php echo $profile; ?>";
		    if(piclink.length > 2) {
		        $("#avatar").attr("src", piclink);
		    }
		    $("#title").text("<?php echo $name; ?>");
            if(<?php echo $auth1; ?> == 0) {
		        $("#twitter").css('opacity', '.4');
		        $("#myonoffswitch-1").prop("disabled", true);
		    }
		    if(<?php echo $auth2; ?> == 0) {
		        $("#facebook").css('opacity', '.4');
		        $("#myonoffswitch-2").prop("disabled", true);
		    }
		    if(<?php echo $auth3; ?> == 0) {
		        $("#tumblr").css('opacity', '.4');
		        $("#myonoffswitch-3").prop("disabled", true);
		    }
		    var twSwitch = 1;
		    var fbSwitch = 1;
		    var tbSwitch = 1;
            $("#myonoffswitch-1").change(function() {
                twSwitch = this.checked ? 0 : 1;
            });
            $("#myonoffswitch-2").change(function() {
                fbSwitch = this.checked ? 0 : 1;
            });
            $("#myonoffswitch-3").change(function() {
                tbSwitch = this.checked ? 0 : 1;
            });
            $('div.content:gt(0)').hide();
            var valMap = [
                "Basic",
                "Moderate",
                "Strict",
                "Custom"];
            $("#slider").slider({
                min: 0,
                max: valMap.length - 1,
                value: 0,
                animate: false,
                change: function (event, ui) {
                    $("#amount").val(valMap[ui.value]);
                    var obj = document.getElementById("strictx");
                    if (valMap[$("#slider").slider("value")] == "Custom") {
                    obj.style.display = "block";
                        }
                    else {
                        obj.style.display = "none";
                        }
                    $('#content' + ui.value).show().siblings('div.content').hide();
                }
            });
            $("#amount").val(valMap[$("#slider").slider("value")]);
        });
		</script>
		<style>
		    a {
		        border-bottom: 0px;
		    }
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
            #ic {
                font-size: .6em;
                display: inline-block;
                margin-right: 5px;
            }
            .line {
                display: inline-block;
                margin-top: 5px;
            }
            .date {
               display: inline-block;
               margin-right: 5px;
               color: white;
               font-size: 16px;
            }
            .retweets {
                display: inline-block;
                margin-right: 5px;
                color: white;
                font-size: 16px;
            }
            .favorites {
                display: inline-block;
                margin-right: 5px;
                color: white;
                font-size: 16px;
            }
            .tumpics {
                max-width: 45%;
                max-height: 120px;
                padding: 5px;
            }
            .tumbcontainer {
                padding: 10px;
            }
            .twitpics {
                max-width: 45%;
                max-height: 120px;
                padding: 5px;
            }
            .fbPicture {
              max-width: 45%;
                max-height: 120px;
                padding: 5px;  
            }

.loader {
  position: absolute;
  left: 50%;
  top: 50%;
  width: 48.2842712474619px;
  height: 48.2842712474619px;
  margin-left: -24.14213562373095px;
  margin-top: -24.14213562373095px;
  border-radius: 100%;
  -webkit-animation-name: loader;
          animation-name: loader;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: linear;
          animation-timing-function: linear;
  -webkit-animation-duration: 4s;
          animation-duration: 4s;
}
.loader .side {
  display: block;
  width: 6px;
  height: 20px;
  background-color: #3498db;
  margin: 2px;
  position: absolute;
  border-radius: 50%;
  -webkit-animation-duration: 1.5s;
          animation-duration: 1.5s;
  -webkit-animation-iteration-count: infinite;
          animation-iteration-count: infinite;
  -webkit-animation-timing-function: ease;
          animation-timing-function: ease;
}

.loader {
    display: inline-block;
    position: relative;
    margin-top: 20px;
    margin-left: 0px;
    margin-right: 0px;
    left: 0;
    top: 0;
}

.loader .side:nth-child(1),
.loader .side:nth-child(5) {
  -webkit-transform: rotate(0deg);
      -ms-transform: rotate(0deg);
          transform: rotate(0deg);
  -webkit-animation-name: rotate0;
          animation-name: rotate0;
}
.loader .side:nth-child(3),
.loader .side:nth-child(7) {
  -webkit-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
          transform: rotate(90deg);
  -webkit-animation-name: rotate90;
          animation-name: rotate90;
}
.loader .side:nth-child(2),
.loader .side:nth-child(6) {
  -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
          transform: rotate(45deg);
  -webkit-animation-name: rotate45;
          animation-name: rotate45;
}
.loader .side:nth-child(4),
.loader .side:nth-child(8) {
  -webkit-transform: rotate(135deg);
      -ms-transform: rotate(135deg);
          transform: rotate(135deg);
  -webkit-animation-name: rotate135;
          animation-name: rotate135;
}
.loader .side:nth-child(1) {
  top: 24.14213562373095px;
  left: 48.2842712474619px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(2) {
  top: 41.21320343109277px;
  left: 41.21320343109277px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(3) {
  top: 48.2842712474619px;
  left: 24.14213562373095px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(4) {
  top: 41.21320343109277px;
  left: 7.07106781636913px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(5) {
  top: 24.14213562373095px;
  left: 0px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(6) {
  top: 7.07106781636913px;
  left: 7.07106781636913px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(7) {
  top: 0px;
  left: 24.14213562373095px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
.loader .side:nth-child(8) {
  top: 7.07106781636913px;
  left: 41.21320343109277px;
  margin-left: -3px;
  margin-top: -10px;
  -webkit-animation-delay: 0;
          animation-delay: 0;
}
@-webkit-keyframes rotate0 {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  60% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
  }
}
@keyframes rotate0 {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  60% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
  }
  100% {
    -webkit-transform: rotate(180deg);
            transform: rotate(180deg);
  }
}
@-webkit-keyframes rotate90 {
  0% {
    -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
  }
  60% {
    -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
  }
  100% {
    -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
  }
}
@keyframes rotate90 {
  0% {
    -webkit-transform: rotate(90deg);
            transform: rotate(90deg);
  }
  60% {
    -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
  }
  100% {
    -webkit-transform: rotate(270deg);
            transform: rotate(270deg);
  }
}
@-webkit-keyframes rotate45 {
  0% {
    -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
  }
  60% {
    -webkit-transform: rotate(225deg);
            transform: rotate(225deg);
  }
  100% {
    -webkit-transform: rotate(225deg);
            transform: rotate(225deg);
  }
}
@keyframes rotate45 {
  0% {
    -webkit-transform: rotate(45deg);
            transform: rotate(45deg);
  }
  60% {
    -webkit-transform: rotate(225deg);
            transform: rotate(225deg);
  }
  100% {
    -webkit-transform: rotate(225deg);
            transform: rotate(225deg);
  }
}
@-webkit-keyframes rotate135 {
  0% {
    -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
  }
  60% {
    -webkit-transform: rotate(315deg);
            transform: rotate(315deg);
  }
  100% {
    -webkit-transform: rotate(315deg);
            transform: rotate(315deg);
  }
}
@keyframes rotate135 {
  0% {
    -webkit-transform: rotate(135deg);
            transform: rotate(135deg);
  }
  60% {
    -webkit-transform: rotate(315deg);
            transform: rotate(315deg);
  }
  100% {
    -webkit-transform: rotate(315deg);
            transform: rotate(315deg);
  }
}
@-webkit-keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
@keyframes loader {
  0% {
    -webkit-transform: rotate(0deg);
            transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
  }
}
.loader {
    display: inline-block;
    position: relative;
    margin-top: 20px;
    margin-left: 0px;
    margin-right: 0px;
    left: 0;
    top: 0;
}
		</style>
	</head>
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
								<li><a href="#dashboard" id="dashboard-link" class="skel-layers-ignoreHref"><span class="icon fa-dashboard">Dashboard</span></a></li>
								<li><a href="http://proj-309-08.cs.iastate.edu/cs309_g8_censure/signupauth.php" id="social-link" class="skel-layers-ignoreHref"><span class="icon fa-th">Accounts</span></a></li>
								<li><a href="http://proj-309-08.cs.iastate.edu/cs309_g8_censure/settings.php" id="contact-link" class="skel-layers-ignoreHref"><span class="icon fa-envelope">Settings</span></a></li>
							    <li><a href="http://proj-309-08.cs.iastate.edu/cs309_g8_censure/logout.php" id="logout-link" class="skel-layers-ignoreHref"><span class="icon fa-power-off">Logout</span></a></li>
							</ul>
						</nav>
				</div>
			</div>

		<!-- Main -->
			<div id="main">
					<section id="dashboard" class="three">
						<div>
							<div id="twitter" class="onoffswitch" style="text-align:left;">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-1"/>
                                <label class="onoffswitch-label" for="myonoffswitch-1">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch" style="background-image: url('images/twitterdash.png');"></span>
                                </label>
                            </div>
                            
                            <div id="facebook" class="onoffswitch" style="text-align:left;">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-2"/>
                                <label class="onoffswitch-label" for="myonoffswitch-2">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch" style="background-image: url('images/facebookdash.png');"></span>
                                </label>
                            </div>
                            
                            <div id="tumblr" class="onoffswitch" style="text-align:left;">
                                <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch-3"/>
                                <label class="onoffswitch-label" for="myonoffswitch-3">
                                    <span class="onoffswitch-inner"></span>
                                    <span class="onoffswitch-switch" style="background-image: url('images/tumblrdash.png');"></span>
                                </label>
                            </div>
						</div>
                <center>
                    <div id="slider"></div>
                    <div id="planlabel">
                        <p>
                            <label for="strictness" style="font-weight: 600; color: #222629; margin-left: 15%;">Strictness:</label>
                            <input type="text" id="amount" style="border: 0; color: #3498db; font-weight: bold;" readonly />
                        </p>
                    </div>
                    <input type="text" id="strictx" style="display:none" placeholder="Comma separated flag terms" size="27" style="margin-bottom:5px;">
                </center>
                
                <div id="content0" class="content"></div>
                <div id="content1" class="content"></div>
                <div id="content2" class="content"></div>
                <div id="content3" class="content"></div>
                <div class="bttn" style="color:#ffffff; margin-top:30px;">
                    <a class="link">
                        <p id="left" class="pl" style="padding-top: 0px;">
                            <span id="runner">Run</span>
                        </p>
                    </a>
            </div>
            <div id="postcontainer">
                <div id="appendto" style="text-align:left; padding: 25px;"></div>
            </div>
            <div id="loader"><div class="loader">
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
  <div class="side"></div>
</div></div>
                					</section>
                			</div>
			<div id="footer">
					<ul class="copyright">
						<li>&copy; Censure. All rights reserved.</li>
					</ul>
			</div>
	</body>
</html>