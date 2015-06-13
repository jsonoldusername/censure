<!DOCTYPE HTML>
<?php
session_start();
//TODO following line is used for testing purposes only. Sets login to true.
$_SESSION['login'] = "1";

if($_SESSION['login'] != "1") {
    // Redirection to front page for user to signup or login
    header("location: front_page.php");
}

if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'twitter') {
        header("Location: RequestTwitterAuth.php");
    } else if ($oauth_provider == 'facebook') {
        header("Location: GrantTest/fbconfig.php");
    }
}
$twitterimage = 'images/tw_login.png';
$facebookimage = 'images/fb_login.png';
$disabled = 'disabled';

if($_SESSION['twitterlogin'] == true) {
    $twitterimage = 'images/tw_login2.png';
    $disabled = '';
}

if($_SESSION['facebooklogin'] == true) {
    $facebookimage = 'images/fb_login2.png';
    $disabled = '';
    //======================================Facebook======================================    
  
    $SQL = "SELECT username, user_key, token 
		        FROM Facebook 
		        WHERE username = " .$_SESSION['username'];
		$result = mysqli_query($connection, $SQL);
		if ($result){
		    $num_rows = mysqli_num_rows($result);
		} else{
		    $errorMessage = $errorMessage . mysqli_error($connection) . "<BR>";
		    $errorMessage = $errorMessage . "Query: " . $SQL . "<BR>";
		}

		if ($num_rows > 0) {
		     while($row = $result->fetch_assoc()) {
		         FacebookSession::setDefaultApplication( '761697260574368','54130ee7389712a5c63b41a4b07d933f' );
		         $longLivedAccessToken = new AccessToken($row["token"]);
		         $session = new FacebookSession($longLivedAccessToken);
	    	$request = new FacebookRequest($session, 'GET', '/me');
		    $graphObject = $request->execute()
		      ->getGraphObject();
		      
     	    $_SESSION['fbid'] = $graphObject->getProperty('id');              // To Get Facebook ID
 	        $_SESSION['fbfullname'] = $graphObject->getProperty('name'); // To Get Facebook full name
	        $_SESSION['femail'] = $graphObject->getProperty('email');    // To Get Facebook email ID
            }
		}
}

	function logout(){
	session_unset();
	//header("location: front_page.php");
}

?>
<html>
	<head>
		<title>Facebook | Twitter Login</title>

		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/jquery.scrolly.min.js"></script>
		<script src="js/jquery.scrollzer.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-wide.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<body>
    

		<!-- Header -->
			<div id="header" class="skel-layers-fixed">

				<div class="top">
                    <script type="text/javascript"> 
					<!-- Logo -->
					if ($_SESSION['facebooklogin'] == true){
						<div id="logo">
							<span class="image avatar48"><img src="https://graph.facebook.com/<?php echo $_SESSION['fbid']; ?>/picture"></span>
							<h1 id="title">"<?php echo $_SESSION['fbfullname']; ?>"</h1>
							<p>Clean your social image!</p>
						</div>
					}
					else {
						<div id="logo">
							<span class="image avatar48"><img src="images/censure.png" alt="" height="42" width="42"/></span>
							<h1 id="title">Censure</h1>
							<p>Clean your social image!</p>
						</div>    
					
					</script>
					<!-- Nav -->
						<nav id="nav">
							<!--
							
								Prologue's nav expects links in one of two formats:
								
								1. Hash link (scrolls to a different section within the page)
								
								   <li><a href="#foobar" id="foobar-link" class="icon fa-whatever-icon-you-want skel-layers-ignoreHref"><span class="label">Foobar</span></a></li>

								2. Standard link (sends the user to another page/site)

								   <li><a href="http://foobar.tld" id="foobar-link" class="icon fa-whatever-icon-you-want"><span class="label">Foobar</span></a></li>
							
							-->
							<ul>
								<li><a href="#top" id="top-link" class="skel-layers-ignoreHref"><span class="icon fa-home">Intro</span></a></li>
								<li><a href="#social" id="social-link" class="skel-layers-ignoreHref"><span class="icon fa-th">Social Plugins</span></a></li>
								<li><a href="#about" id="about-link" class="skel-layers-ignoreHref"><span class="icon fa-user">About Me</span></a></li>
								<li><a href="#contact" id="contact-link" class="skel-layers-ignoreHref"><span class="icon fa-envelope">Contact</span></a></li>
							    <li><a href="http://proj-309-08.cs.iastate.edu/cs309_g8_censure/logout.php" id="logout-link" class="icon fa-logout"><span class="skel-layers-ignoreHref">Logout</span></a></li>

							</ul>
						</nav>
						
				</div>
				
				<div class="bottom">

					<!-- Social Icons -->
						<ul class="icons">
							<li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
							<li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
							<li><a href="#" class="icon fa-github"><span class="label">Github</span></a></li>
							<li><a href="#" class="icon fa-dribbble"><span class="label">Dribbble</span></a></li>
							<li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
						</ul>
				
				</div>
			
			</div>

		<!-- Main -->
			<div id="main">
					
				<!-- Portfolio -->
					<section id="social" class="two">
						<div class="container">
					
							<header>
								<h2>Welcome to Censure. Your adventure awaits.</h2>
							</header>
							
							<div id="buttons">
<h1>Twitter Facebook Login </h1>
    <a href="?login&oauth_provider=twitter"><img src="<?=$twitterimage?>"></a>&nbsp;&nbsp;&nbsp;
    <a href="?login&oauth_provider=facebook"><img src="<?=$facebookimage?>"></a> <br />
	<br />
</div>

<center><form action="/cs309_g8_censure/timeline.php">
    <input type="submit" value="Continue" <?=$disabled?>>
</form>
</center>
<center><form action="/cs309_g8_censure/facebookTest.php">
    <input type="submit" value="Continue to test FB" <?=$disabled?>>
</form>
</center>
						</div>
					</section>
			
			</div>

		<!-- Footer -->
			<div id="footer">
				
				<!-- Copyright -->
					<ul class="copyright">
						<li>&copy; Untitled. All rights reserved.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
					</ul>
				
			</div>

	</body>
</html>