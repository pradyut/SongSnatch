<?php
require_once('php/fbook/src/facebook.php');
include_once("php/user.php");
include_once("php/getData.php"); 

$facebook = new Facebook(array(
			'appId'  => '229592867094638',
			'secret' => 'fbe4eb3d5259cdab74fbe33fff2bb9d3',
			'cookie' => true,
));


// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
	try {
    	// Proceed knowing you have a logged in user who's authenticated.
	    $user_profile = $facebook->api('/me'); //Get Facebook info
	    checkUser($user_profile); //Add's user to DB if new user, always also updates friends list
  	} catch (FacebookApiException $e) {
    	echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
	    $user = null;
  	}
}	

?>

<!DOCTYPE html >
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<meta charset="utf-8" name="apple-mobile-web-app-capable" content="yes"/>
		<title>Song Snatch</title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen">
		<?php if ($user) { include 'header.php'; } ?>
	</head>
	
	<body>
		<div id="header">
			<div id="tagline">
				<span>Snatch.</span> Play. Share.
				
			</div>
			
			<div id="signin">	
				<?php if ($user) { ?>
					<span onclick="javascript:signout()">logout</span>
				<?php } ?>
			</div>
		</div>
		<div id='wrapper'>
			<div id='content_wrap'>
				<?php if ($user) { include 'content.php' ?>
					
					
			    <?php } else { ?>
					<fb:login-button></fb:login-button>
			    <?php } ?>
			    
			    <div id="fb-root"></div>
			    <script>
			      window.fbAsyncInit = function() {
			        FB.init({
			          appId: '<?php echo $facebook->getAppID() ?>',
			          cookie: true,
			          xfbml: true,
			          oauth: true
			        });
			        FB.Event.subscribe('auth.login', function(response) {
			          window.location.reload();
			        });
			        FB.Event.subscribe('auth.logout', function(response) {
			          window.location.reload();
			        });
			      };
			      (function() {
			        var e = document.createElement('script'); e.async = true;
			        e.src = document.location.protocol +
			          '//connect.facebook.net/en_US/all.js';
			        document.getElementById('fb-root').appendChild(e);
			      }());
			    </script>
				<div id="content" data-bind="template:{name:function(){ return viewModel.selectedLink().template() }}">
 					
				
				</div>
			</div>
			<?php if ($user) { include 'player.php'; } ?>

		</div>
	</body>

</html>
						