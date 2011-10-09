<?php

require 'php/fbook/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '229592867094638',
  'secret' => 'fbe4eb3d5259cdab74fbe33fff2bb9d3',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
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
		<link type="text/css" href="skin/jplayer.blue.monday.css" rel="stylesheet" />	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script src="js/jquery.jplayer.min.js"></script>
		<script type="text/javascript" src="js/jplayer.playlist.min.js"></script>
		<script type="text/javascript">
		var user_id = 0;
		var a;
		function loadUser(id){
			
			loadMusic(id);

		}
		function signout(){
			FB.logout();
		}
		function loadMusic(id){
			return new Array({
					title:"Cro Magnon Man",
					mp3:"http://www.jplayer.org/audio/mp3/TSP-01-Cro_magnon_man.mp3",
					oga:"http://www.jplayer.org/audio/ogg/TSP-01-Cro_magnon_man.ogg"
				},
				{
					title:"Your Face",
					mp3:"http://www.jplayer.org/audio/mp3/TSP-05-Your_face.mp3",
					oga:"http://www.jplayer.org/audio/ogg/TSP-05-Your_face.ogg"
				},
				{
					title:"Cyber Sonnet",
					mp3:"http://www.jplayer.org/audio/mp3/TSP-07-Cybersonnet.mp3",
					oga:"http://www.jplayer.org/audio/ogg/TSP-07-Cybersonnet.ogg"
				},
				{
					title:"Tempered Song",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-01-Tempered-song.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg"
				},
				{
					title:"Hidden",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-02-Hidden.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-02-Hidden.ogg"
				},
				{
					title:"Lentement",
					free:true,
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-03-Lentement.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-03-Lentement.ogg"
				},
				{
					title:"Lismore",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-04-Lismore.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-04-Lismore.ogg"
				},
				{
					title:"The Separation",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-05-The-separation.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-05-The-separation.ogg"
				},
				{
					title:"Beside Me",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-06-Beside-me.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-06-Beside-me.ogg"
				},
				{
					title:"Bubble",
					free:true,
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-07-Bubble.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-07-Bubble.ogg"
				},
				{
					title:"Stirring of a Fool",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-08-Stirring-of-a-fool.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-08-Stirring-of-a-fool.ogg"
				},
				{
					title:"Partir",
					free: true,
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-09-Partir.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-09-Partir.ogg"
				},
				{
					title:"Thin Ice",
					mp3:"http://www.jplayer.org/audio/mp3/Miaow-10-Thin-ice.mp3",
					oga:"http://www.jplayer.org/audio/ogg/Miaow-10-Thin-ice.ogg"
				})
		}
	    $(document).ready(function(){
	    
	   
			$("#jquery_jplayer_1").jPlayer().bind($.jPlayer.event.timeupdate, function(event) { // Add a listener to report the time play began
				console.log('teststssfd');
		  		$("#playBeganAtTime").html("Play began at time = " + event.jPlayer.status.currentTime);
			});
				
				
	    	var playlist = loadMusic(user_id);
	     	a = new jPlayerPlaylist({
				jPlayer: "#jquery_jplayer_1",
				cssSelectorAncestor: "#jp_container_1"
			}, playlist,
			{
				swfPath: "js",
				supplied: "oga, mp3",
				mode: "window"
			});
		});
	  </script>
	</head>
	
	<body>
		<div id="header">
			<div id="tagline"><span>Snatch. Play. Share.</span></div>
			<div id="signin">	
				<?php if ($user) { ?>
				<span onclick="javascript:signout()">logout</span>
				<?php } ?>
			</div>
		</div>
		<div id="wrapper">
			
			<div id="content_wrap">
				<?php if ($user) { ?>
				<?php echo "<script>user_id = ".$user_profile['id'].";loadUser(user_id);</script>" ?>
			      <?php echo "<p><img src='https://graph.facebook.com/".$user."/picture'/> Hi, <span id='name1'>".$user_profile['name']." </span></p>" ?>
			      <pre>
			        <?php //print htmlspecialchars(print_r($user_profile['name'], true)) ?>
			        <?php //echo "<img src='https://graph.facebook.com/".$user."/picture'/>" ?>
			      </pre>
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
			    <div id="nav">
			    	<ul>
			    		<li>Songs</li>
			    		<li>Friends</li>
			    	</ul>
			    </div>
			    <div id="content">
			    	
			    	<script>
			    		var song;
			    		$.ajax({
							type: "GET",
							url: "php/getSongs.php",
							data:"uid="+user_id,
							dataType:'json',
							success: function(msg) {
								

								var str="";
								for(i=0;i<msg.length;i++){
									song = {
									  title:msg[i].title,
									  artist:msg[i].artist,
									  mp3:msg[i].URL
									};
									var s="title:'"+msg[i].title+"',artist:'"+msg[i].artist+"',mp3:'"+msg[i].URL+"'";
									var d =escape(s);
									str+="<tr><td>"
									str+=msg[i].artist;
									str+="</td>";
									str+="<td>";
									str+=msg[i].title;
									str+="</td>";
									str+="<td>5</td>"
									str+="<td>";
									str+="<a href='javascript:a.add({"+d+"})'>Add</a>"
									//str+="<a href='javascript:a.add("+song+")'>Add</a>";
									str+="</td></tr>"
								}
								$('#songs').append(str);
								
							}
						});
			    	</script>
			    	<div>
			    		<h1>Songs</h1>
			    		<table id="songs">
			    			<tr>
			    				<th>Artist</th>
			    				<th>Title</th>
			    				<th>Play Count</th>
			    				<th>Add To Player</th>
			    			</tr>
			    			
			    		</table>
			    	</div>
			    	<div id='friends'>
			    		<h1>Friends Using Song Snatch</h1>
			    		<span id='playBeganAtTime'>time</span>
				    	<?php 
				    		$facebook = new Facebook(array(
								'appId'  => '229592867094638',
								'secret' => 'fbe4eb3d5259cdab74fbe33fff2bb9d3',
								'cookie' => true,
								));
								 
							$fql = "SELECT uid, name FROM user WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) AND is_app_user = 1";
							$response = $facebook->api(array(
								'method' => 'fql.query',
								'query' =>$fql,
							));
							for($i=0; $i<sizeof($response);$i++){
								//echo($response[$i]['uid']);
								echo "<p><img src='https://graph.facebook.com/".$response[$i]['uid']."/picture'/>   " .$response[$i]['name'];
							}	 
							//print_r($response);
						?>	
					</div>
			</div>
			</div>
			<div id="player">
				
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>
				
				<div id="jp_container_1" class="jp-audio">
					<div class="jp-type-playlist">
						<div class="jp-gui jp-interface">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								
							</ul>
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-progress">
								<div class="jp-seek-bar">
									<div class="jp-play-bar"></div>
								</div>
							</div>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<div class="jp-time-holder">
								<div class="jp-current-time"></div>
								<div class="jp-duration"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle">shuffle</a></li>
								<li><a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off">shuffle off</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<div class="jp-playlist">
							<ul>
								<li></li>
							</ul>
						</div>
						<div class="jp-no-solution">
							<span>Update Required</span>
							To play the media you will need to either update your browser to a recent version or update your 
							<a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
						</div>
					</div>
				
			</div>
		</div>
	</body>
</html>
		
		