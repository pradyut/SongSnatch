<link type="text/css" href="skin/jplayer.blue.monday.css" rel="stylesheet" />	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script src="js/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="js/jplayer.playlist.min.js"></script>
<script type='text/javascript' src='js/jquery.tmpl.js'></script>
<script type="text/javascript" src="js/knockout-1.2.1.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="js/fancybox/jquery.easing-1.3.pack.js"></script>
<link rel="stylesheet" href="js/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.livequery.js"></script>
<script src="js/jquery.address.js" type="text/javascript"></script>
<script src="js/knockout.address.js" type="text/javascript"></script>


<script type="text/html" id="songTemplate"> 
    {{each $data}}
    <tr>
        <td>${snatched}</td>
        <td>${artist}</td>
        <td>${title}</td>
        <td>${count}</td>
		<td><input type="checkbox" data-bind="attr:{value: id}, checked: viewModel.selectedIDs()" /></td>
    </tr>
	{{/each}}
</script>


<script type="text/html" id="friendTemplate"> 
    {{each $data}}
    <tr>
        <td><img src=${pic}/></td>
        <td><a href = '#'>${first} ${last}</a></td>
        <td></td>
        <td>${fid}</td>
    </tr>
	{{/each}}
</script>
<script type="text/html" id="listTemplate"> 
    {{each $data}}
    <tr>
        <td><a data-bind="attr:{value: id}" class="dispList" href = '#'>${name}</a></td>
        <td>${date}</td>
        <td>${count}</td>
		<td><input type="checkbox" data-bind="attr:{value: id}, checked: viewModel.selectedIDs" /></td>
    </tr>
	{{/each}}
</script>
<script type="text/html" id="topTemplate"> 
	<div id ="controls">
		<div data-bind="click:play" class ="button play">
			<a href = '#'><span class="label">Play Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(2)}" class = "button add">
			<a title="Select Playlist To Add To" class="inline" href="#data" ><span class="label">Add Selected</span></a>
		</div>
	</div>
	<br/>
	<h3>Top Songs</h3>
	<table>
	    <thead><tr>
			<th></th><th>Artist</th><th>Title</th><th>Play Count</th><th>Select</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'songTemplate', data: viewModel.pageSongs}"></tbody>    
	</table>
</script>

<script type="text/html" id="histTemplate"> 
	<div id ="controls">
		<div data-bind="click:play" class ="button play">
			<a href = '#'><span class="label">Play Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(2)}" class = "button add">
			<a title="Select Playlist To Add To" class="inline" href="#data" ><span class="label">Add Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(0)}" class = "button delete">
			<a title="Delete Song(s) From Playlist?" class="inline" href="#data"><span class="label">Delete Selected</span></a>
		</div>
		
		<div id = "visibility">
			<form>
			See:
			<input type="radio" name="whatever" value="all" /> All
			<input type="radio" name="whatever" value="snatched" /> Snatched
			</form>
		</div>
	</div>
	<br/>
	<h3>Song History</h3>
	<table>
	    <thead><tr>
	        <th>Snatched?</th><th>Artist</th><th>Title</th><th>Play Count</th><th>Select</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'songTemplate', data: viewModel.pageSongs}"></tbody>    
	</table>
</script>
<!--
						<div id ="button sort">
							<a href= '#'><span class="label">Sort</span></a>
						</div>
-->

<script type="text/html" id="playTemplate"> 
	<div id ="controls">
		<div data-bind="click:play_playList" class ="button play">
			<a href = '#'><span class="label">Play Playlist</span></a>
		</div>
		<div data-bind="click: function() { viewModel.lightTemp('addPlistBoxTemp')}" class = "button add">
			<a title="Enter A Playlist Name" class="inline" href="#data"><span class="label">New Playlist</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(1)}" class = "button delete">
			<a title="Delete Playlist(s)?" class="inline" href="#data"><span class="label">Delete Playlist</span></a>
		</div>		
		<div id = "visibility">
			<form>
			See:
			<input type="radio" name="whatever" value="all" /> All
			<input type="radio" name="whatever" value="snatched" /> Subscribed 
			</form>
		</div>
	
	</div>
	<br/>
	<h3>Playlists</h3>
	<table>
	    <thead><tr>
	        <th>Name</th><th>Date</th><th>Song Count</th><th>Select</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'listTemplate', data: viewModel.pageLists}"></tbody>    
	</table>
</script>

<script type="text/html" id="playSongTemplate"> 
	<h3>Playlists - ${name}</h3>
	<div id ="controls">
		<div data-bind="click:play" class ="button play">
			<a href = '#'><span class="label">Play Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(2)}" class = "button add">
			<a title="Select Playlist To Add To" class="inline" href="#data" ><span class="label">Add Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItems(0)}" class = "button delete">
			<a title="Delete Song(s) From Playlist?" class="inline" href="#data"><span class="label">Delete Selected</span></a>
		</div>
		
		<div id = "visibility">
			<form>
			See:
			<input type="radio" name="whatever" value="all" /> All
			<input type="radio" name="whatever" value="snatched" /> Snatched
			</form>
		</div>
	</div>
	<br/>
	<h3>Song History</h3>
	<table>
	    <thead><tr>
	        <th>Snatched?</th><th>Artist</th><th>Title</th><th>Play Count</th><th>Select</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'songTemplate', data: viewModel.pageSongs}"></tbody>    
	</table>
</script>


<script type="text/html" id="fTemplate"> 
	
	
	<h3>Friends</h3>
	<table>
	    <thead><tr>
	        <th>Picture</th><th>Name</th><th>Song Count</th><th>Playlist Count</th><th>Friends</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'friendTemplate', data: viewModel.friends}"></tbody>    
	</table>
</script>



<script type='text/javascript'>		
	var player;
	var uid= 0;
	var curr_pid=0;
	var selSongs;
	var linkObj = function(name,img,alt,template) {
	    this.name=name;
	    this.img=img;
	    this.alt=alt;
	    this.sel=ko.observable(img);
	    this.template = ko.observable(template);
	}
	var slink = new linkObj('Songs','img/songs.png','img/songs-b.png','histTemplate');
	var plink = new linkObj('Playlists','img/playlists.png','img/playlists-b.png','playTemplate');
	var flink = new linkObj('Friends','img/friends.png','img/friends-b.png','fTemplate');
	var tlink = new linkObj('Top Music','img/topsongs.png','img/topsongs-b.png','topTemplate');
	var serlink = new linkObj('Search','img/search.png','img/search-b.png','searchTemplate');
		
	var song = function(id,artist,title,count,mp3,oga,snatched) {
	    this.id=id;
	    this.mp3=mp3;
	    this.oga=oga;
	    this.artist=artist;
	    this.title=title;
	    this.count=count;
	    this.snatched=snatched;
	    this.remove = function() { viewModel.pageSongs.remove(this) }
	}
	
	var friend = function(pic,first,last,fid) {
	    this.pic=pic;
	    this.first=first;
	    this.last=last;
	    this.fid=fid;
	    this.remove = function() { viewModel.friends.remove(this) }
	}
	var list = function (id,name,date,count,uid,songs){
		this.id=id;
		this.name=name;
		this.date=date;
		this.count=count;
		this.uid=uid;
		this.songs=songs;
		this.remove = function() { viewModel.pageLists.remove(this) }
	}

	var viewModel = {
		links: [slink,plink,flink,tlink,serlink],
	    selectedLink: ko.observable(slink),

	    // Behaviours
	    selectLink: function (link) { 
	        this.selectedLink(link);
	        link.sel(link.alt);
	        switch(link.name){
	        	case 'Songs':
	        		this.loadMySongs();
	        		break;
	        	case 'Playlists':
		        	this.loadLists();
		        	this.selectedLink().template('playTemplate');
		        	break;
	        	case 'Search':
	        		
	        		break;
	        	case 'Friends':
		        	this.loadFriends();
		        	break;
	        
	        	default:
	    	    	this.loadTop(uid);
	    	    	break;
			}
	    },
	    pageSongs: ko.observableArray(),
	    play_playList:function(){
	    	var lists;
	    	ko.utils.arrayForEach(viewModel.selectedIDs(), function(item) {
		    	lists = ko.utils.arrayFilter(viewModel.pageLists(), function(plist) {
    	    		return plist.id ==item;
    			});
    		})
			ko.utils.arrayForEach(lists, function(plist){
				ko.utils.arrayForEach(plist.songs, function(song){
					player.add(song)	
				})
			})
    	},
	    play:function(){
			for(var i=0;i<viewModel.selectedIDs().length;i++){
				ko.utils.arrayForEach(this.pageSongs(), function(song){
					if(song['id']==viewModel.selectedIDs()[i])
						player.add(song)
				})
			}
		},
		loadMySongs:function(){
			viewModel.loadSongsByPid(d[0].id);
			curr_pid=d[0].id
		},
		songFactory:function(data, song_arr){
			for(var i=0;i<data.length;i++){
				song_arr.push(new song(data[i].id,data[i].artist,data[i].title,data[i].count,data[i].mp3,data[i].oga,data[i].snatched))
			}
		},
	    friends: ko.observableArray(),
	    pageLists:ko.observableArray(),
	   	selectedIDs: ko.observableArray(),
	   	loadSongsByPid: function(pid){
	   		viewModel.pageSongs.removeAll();
			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getSongsWithURL&pid="+pid,
				dataType:'json',
				success: function(msg) {
					viewModel.songFactory(msg,viewModel.pageSongs)
				}
			});

	   	},
	   	loadLists: function(){
	   		
	   		$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getListURL&uid="+uid,
				dataType:'json',
				success: function(msg) {
					viewModel.pageLists.removeAll();
					var d =ko.utils.arrayMap(msg, function(plist) {
   		 				viewModel.pageLists.push(new list(plist.id,plist.name, plist.date, plist.song_count,plist.user_id,plist.tracks));
					});
				}
			})	
		},	
		loadTop:function(uid){
			viewModel.pageSongs.removeAll();
			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getTopSongs",
				dataType:'json',
				success: function(msg) {
					if(uid!=0){
						viewModel.songFactory(msg,viewModel.pageSongs)
					}
				}
			});
		},
		loadFriends: function(){

			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getFriends&uid="+uid,
				dataType:'json',
				success: function(msg) {
					viewModel.friends.removeAll();
					var d =ko.utils.arrayMap(msg, function(friends) {
   		 				viewModel.friends.push(new friend(friends.pic,friends.first, friends.last, friends.fid));
					})
				}
			})
		},
		lightTemp: ko.observable("addPlistBoxTemp")			
	}
	
	viewModel.listToAdd = ko.observable("");
	viewModel.addList = function () {
		
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=newPList&uid="+uid+"&name="+viewModel.listToAdd(),
			success: function(msg) {
				viewModel.loadLists();
				$.fancybox.close();
			}
		})
	}
	viewModel.addToList = function () {
		var str = viewModel.selectedIDs().join('^');
		var song_str = selSongs.join('^');
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=saveToPlayList&pid="+str+"&sid="+song_str,
			success: function(msg) {
				console.log(msg)
				selSongs=[];
				viewModel.selectedIDs.removeAll();
				$.fancybox.close();
			}
		})
	}
	
	viewModel.selItemsName = ko.observableArray();
	viewModel.selectItems = function(type){
		if(viewModel.selectedIDs().length > 0){
			viewModel.selItemsName.removeAll();
			var selected_arr=viewModel.selectedIDs();
			var item_arr=viewModel.pageSongs();
			
			if(type=='1'){
				console.log('here')
				viewModel.lightTemp('delPlistBoxTemp');
				item_arr=viewModel.pageLists();
			}
			else if(type=='2'){
				selSongs=viewModel.selectedIDs();
				selected_arr=selSongs;
				viewModel.selectedIDs.removeAll();
				viewModel.lightTemp("addSongBoxTemp")	
			}
			else
				viewModel.lightTemp('delSongBoxTemp');
			ko.utils.arrayForEach(selected_arr, function(id){
				ko.utils.arrayForEach(item_arr, function(item){
					if(item['id']==id)
						if(type=='1')
							viewModel.selItemsName.push(item['name'])
						else
							viewModel.selItemsName.push(item['title']+" - "+item['artist'])
				})
			})	
		}			
		else{
			viewModel.lightTemp('delErrBoxTemp');	
		}
	}
	
	viewModel.delSongConfirm = function () {
		var str = viewModel.selectedIDs().join('^');
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=delSongs&pid="+curr_pid+"&sid="+str,
			success: function(msg) {
				console.log(msg)
				viewModel.selectedIDs.removeAll();
				viewModel.loadSongsByPid(curr_pid);
				$.fancybox.close();
			},
			error: function(msg){

			}
		})	
	}

	viewModel.delListConfirm = function () {
		var str = viewModel.selectedIDs().join('^');
		
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=delPlaylist&pid="+str,
			success: function(msg) {
				viewModel.selectedIDs.removeAll();
				viewModel.loadLists();
				$.fancybox.close();
			},
			error: function(msg){
			
			}
		})	
	}
	
	var link_map = {};
	link_map['slink'] = slink;
	link_map['flink'] = flink;
	link_map['tlink'] = tlink;
	link_map['plink'] = plink;
	link_map['serlink'] = serlink;
	viewModel.selectedLinkStr = ko.observable("slink");
	ko.dependentObservable(function () {
		viewModel.selectedLink(link_map[viewModel.selectedLinkStr()]);
		/*
switch(viewModel.selectedLinkStr()){
        	case 'serlink':
        		viewModel.selectedLink(serlink);
        		break;
        	case 'plink':
        		viewModel.selectedLink(plink);
        		break;
        	case 'tlink':
        		viewModel.selectedLink(tlink);
        		break;
        	case 'flink':
        		viewModel.selectedLink(flink);
        		break;
        	default:
        		viewModel.selectedLink(slink);
        		break;		}
*/
	})

	
	var d = <?php echo getLists($user_profile['id']) ?>;

	$(document).ready(function(){
		
		ko.applyBindings(viewModel);  	
 		ko.linkObservableToUrl(viewModel.selectedLinkStr, "link",'slink' ); 
		viewModel.songFactory(d[0].tracks,viewModel.pageSongs);
		curr_pid=d[0].id;
		
		
		viewModel.loadLists();
		$(".dispList").live('click',function(){
			if(viewModel.selectedLink().template()=='playTemplate'){
				console.log($(this).attr('value'))
				curr_pid=$(this).attr('value')
				viewModel.loadSongsByPid(curr_pid)
				viewModel.selectedLink().template('playSongTemplate')
			}
		})
		$("a.inline").livequery(function(){ 
			 $(this).fancybox({
			 	'transitionIn'	:	'elastic',
				'transitionOut'	:	'elastic',
				'speedIn'		:	600, 
				'speedOut'		:	200,
				'width'			: 	600,
				'height'		: 	200,
				'scrolling'		:	'auto',
				'autoDimensions': 	true,
				'autoScale'		: 	true,
				onComplete : function() 
        		{
        			$(this).fancybox().resize();
        		} 
			 })
		});      		
		
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

<script type="text/html" id="addPlistBoxTemp"> 
	<form data-bind="submit: viewModel.addList">
		Name:
		<input data-bind='value: viewModel.listToAdd, valueUpdate: "afterkeydown"' id="list_name" type="text" />
		<br/>
		<br/>
		<button data-bind="click: function() {$.fancybox.close()}">Cancel</button>
		<button type="submit" data-bind="enable: viewModel.listToAdd().length > 0">Create</button>
	</form>
</script>

<script type="text/html" id="addSongBoxTemp"> 
	<form data-bind="submit: viewModel.addToList">
		Add Songs
		<br/>
		{{each $data}}
		<p> ${$index + 1}: <em>${$value}</em></p>
		{{/each}}
		<p>To</p>
		<br/>
		Select Playlist(s)
		<br/>
		<table>
	    <thead><tr>
	        <th>Name</th><th>Date</th><th>Song Count</th><th>Select</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'listTemplate', data: viewModel.pageLists}"></tbody>    
		</table>
		<button data-bind="click: function() {$.fancybox.close()}">Cancel</button>
		<button type="submit" data-bind="enable: viewModel.selectedIDs().length > 0">Add</button>
	</form>
</script>

<script type="text/html" id="delPlistBoxTemp"> 
	
		Do you want to delete:
		<br/>
		{{each $data}}
		<p> ${$index + 1}: <em>${$value}</em></p>
		{{/each}}	
		<button data-bind="click: function() {$.fancybox.close()}">Cancel</button>
		<button data-bind="click: viewModel.delListConfirm" type="submit">Delete</button>
	
</script>

<script type="text/html" id="delSongBoxTemp"> 
	
		Do you want to delete:
		<br/>
		{{each $data}}
		<p> ${$index + 1}: <em>${$value}</em></p>
		{{/each}}	
		<button data-bind="click: function() {$.fancybox.close()}">Cancel</button>
		<button data-bind="click: viewModel.delSongConfirm" type="submit">Delete</button>
	
</script>


<script type="text/html" id="delErrBoxTemp"> 
	Please select at least
	<br/>
	<em>one</em> item to delete:
	<br/>
	<br/>
	<button data-bind="click: function() {$.fancybox.close()}">Close</button>
</script>


