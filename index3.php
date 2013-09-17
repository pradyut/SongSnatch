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
	    $user_profile = $facebook->api('/me');
	    checkUser($user_profile);
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
		<script type='text/javascript' src='js/jquery.tmpl.js'></script>
		<script type="text/javascript" src="js/knockout-1.2.1.js"></script>
		
		
		<script type="text/x-jquery-tmpl" id="songTemplate"> 
		    {{each $data}}
		    <tr>
		        <td>${snatched}</td>
		        <td>${artist}</td>
		        <td>${title}</td>
		        <td>${count}</td>
		        <td><input type="checkbox" data-bind="attr:{value: id}, checked: $item.selected" /></td>
		    </tr>
			{{/each}}
		</script>
		
		


		<script type='text/javascript'>
			
			
			var player;
			var uid= 0;
			
			var song = function(id,snatched,artist,title,count,mp3,oga) {
			    this.snatched=snatched;
			    this.id=id;
			    this.mp3=mp3;
			    this.oga=oga;
			    this.artist=artist;
			    this.title=title;
			    this.count=count;
			    this.remove = function() { viewModel.songs.remove(this) }
			}
			var playlist = function(id,name,date,song_arr){
				this.id=id;
				this.name=name;
				this.date=date;
				this.song_arr=ko.observableArray(song_arr);
				this.addSongToList = function (song) {
        			this.song_arr.push(song);
    			}.bind(this);
			}
			function saveListToDB(pid,sid,count,snatched){
				
				$.ajax({
					type: "GET",
					url: "php/saveData.php",
					data:"f=savePlayList&pid="+pid+"&sid="+sid+"&count="+count+"&snatched="+snatched,
					dataType:'json',
					success: function(msg) {
						
					}
				})
			}
			function delFromListDB(pid,sid){
				$.ajax({
					type: "GET",
					url: "php/saveData.php",
					data:"f=delPlayList&pid="+pid+"&sid="+sid,
					dataType:'json',
					success: function(msg) {
						
					}
				})
			}
			var d = <?php echo getLists($user_profile['id']) ?>;
			var viewModel = {
			    songs: ko.observableArray([
			       
			    ]),
			    playlists:ko.observableArray([
			    	
			    ]),
			   	selectedSongs: ko.observableArray(["3","1"]),
			   	playSelected:ko.observableArray(),
				play:function(){
					for(i=0;i<viewModel.selectedSongs().length;i++){
						ko.utils.arrayForEach(this.songs(), function(song){
							if(song['id']==viewModel.selectedSongs()[i])
								player.add(song)
						})
					}
				},
			    addSong: function(id,snatched,artist,title,count,mp3,oga) {
			        this.songs.push(new song(id,snatched,artist,title,count,mp3,oga));   
			    },
			   
				addToList: function(){
					var pid=viewModel.playlists()[0]['id'];
					
					ko.utils.arrayForEach(this.playlists(), function(playlist){
						
						if(playlist['id']==pid){
							for(i=0;i<viewModel.selectedSongs().length;i++){
								var found = false
								ko.utils.arrayForEach(playlist.song_arr(), function(song){
									if(song['id']==viewModel.selectedSongs()[i]){
										found=true;
									}
								})
								if(!found){
									ko.utils.arrayForEach(viewModel.songs(), function(song){
										if(song['id']==viewModel.selectedSongs()[i]){
											playlist.song_arr.push(song)
											saveListToDB(pid,song['id'],song['count'],song['snatched']);
										}
									})
								}
							}
						}
					})	

			   },
			   delFromList: function(){
			   		var pid=viewModel.playlists()[0]['id'];
			   		ko.utils.arrayForEach(this.playlists(), function(playlist){
						
						if(playlist['id']==pid){
							for(i=0;i<viewModel.playSelected().length;i++){
								var found = false
								ko.utils.arrayForEach(playlist.song_arr(), function(song){
									if(song['id']==viewModel.playSelected()[i]){
										playlist.song_arr.remove(song)
										delFromListDB(pid,song['id']);
									}
								})
							}
						}
					})	
			   },
			   
			    
			};
			
			for(i=0;i<d.length;i++){
						viewModel.playlists.push(new playlist(d[i].id,d[i].name,d[i].date,d[i].tracks));
					}
			var arr = <?php echo getSongs() ?> ;
			for(i=0;i<arr.length;i++){
				viewModel.addSong(arr[i]['id'],arr[i]['snatched'],arr[i]['artist'],arr[i]['title'],arr[i]['count'],arr[i]['mp3'],arr[i]['oga'])
			}
		
			$(document).ready(function(){
				ko.applyBindings(viewModel);  
			/*
			$("#jquery_jplayer_1").jPlayer().bind($.jPlayer.event.timeupdate, function(event) { // Add a listener to report the time play began
				console.log('teststssfd');
		  		$("#playBeganAtTime").html("Play began at time = " + event.jPlayer.status.currentTime);
			});
			*/
			
				
	     	
		     	player = new jPlayerPlaylist({
					jPlayer: "#jquery_jplayer_1",
					cssSelectorAncestor: "#jp_container_1"
				}, "",
				{
					swfPath: "js",
					supplied: "oga, mp3",
					mode: "window"
				});
			});
				function signout(){
					FB.logout();
				}
		
		</script>
	</head>

	<body>
		<div id="header">
			<div id="tagline"><span>Snatch.</span> Play. Share.</div>
			<div id="signin">	
				<?php if ($user) { ?>
					<span onclick="javascript:signout()">logout</span>
				<?php } ?>
			</div>
		</div>
		<div id='wrapper'>
			<div id='content_wrap'>
				<?php if ($user) { ?>
					<?php echo "<script>uid=".$user_profile['id']."</script>" ?>
					<?php echo "<div><span><img src='https://graph.facebook.com/".$user_profile['id']."/picture'/> Hi, ".$user_profile['name']."</span>" ?>
					<?php echo "<ul id='nav'>
						<li><a  href = '#'><img src = 'img/songs.png'/>Songs</a></li>
						<li><a href = '#'><img src = 'img/playlists.png'/> Playlists</a></li>
						<li><a class='selected'href = '#'><img src = 'img/friends-b.png'/> Friends</a></li>
						<li><a href = '#'><img src = 'img/topsongs.png'/> Top Music</a></li>
					</ul></div>" ?>
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
				<div id="content">
							
					
					<div id ="controls">
						<div data-bind="click:play" id ="play_selection">
							<a href = '#'><span class="label">Play Selected</span></a>
						</div>
						<div data-bind="click:addToList" id ="add_selection">
							<a href = '#'><span class="label">Add Selected</span></a>
						</div>
						<div data-bind="click:delFromList" id ="delete_selection">
							<a href = '#'><span class="label">Delete Selected</span></a>
						</div>
						
						<div id = "visibility">
							<form>
							See:
							<input type="radio" name="whatever" value="all" /> All
							<input type="radio" name="whatever" value="snatched" /> Snatched
							</form>
						</div>
						
						<!--
<div id ="sort_selection">
							<a href= '#'><span class="label">Sort</span></a>
						</div>
-->
					</div>
					<table>
					    <thead><tr>
					        <th>Snatched?</th><th>Artist</th><th>Title</th><th>Play Count</th><th>Select</th>
					    </tr></thead>
					    
 					    <tbody data-bind="template: {name:'songTemplate', data: songs,templateOptions: {selected: selectedSongs}}"></tbody> 
					</table>
					<h3>Song History</h3>
					
					<div data-bind="template:{name:'playTemplate',foreach:playlists}">
						
					    

						
					</div>
					<script type="text/x-jquery-tmpl" id="playTemplate"> 
  					 
						<h3 data-bind="text: name"></h3>
						<h4 data-bind="text: date"></h4>	
						<table>
					    	<thead>
					    		<tr>
					        		<th>Snatched?</th><th>Artist</th><th>Title</th><th>Play Count</th><th>Select</th>
					    		</tr>
					    	</thead>
					    	<tbody data-bind='template: { name: "songTemplate", templateOptions: {selected: viewModel.playSelected}, data: song_arr }'></tbody>  					    	
					    </table>        			        		
					
					</script>
 				</div>
			</div>
			<div id='player'>
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>
				
				<div id="jp_container_1" class="jp-audio">
					<div class="jp-type-playlist">
						<div class="jp-gui jp-interface">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-previous" tabindex="1">previous</a></li>
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-next" tabindex="1">next</a></li>
<!-- 								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li> -->
								
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