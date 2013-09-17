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
<script src="js/jquery.timeago.js" type="text/javascript"></script>




<!--Search Page Template-->
<script type="text/html" id="searchTemplate"> 	
	<br/>
	<form data-bind="submit: viewModel.query">
	    <p style='padding-left:15px;'><span>
	    <input size='45' placeholder="Enter A Query" data-bind='value: viewModel.searchTerm' />
	    <button type="submit">Search</button>
	    </span>
	    
	    </p>
	</form>
	
	<br/>
	
	<h3 data-bind="visible: viewModel.search.songArr().length==0 && viewModel.searchTerm()">There Were No Matches</h3>
	<div data-bind="visible: viewModel.search.songArr().length>0, template: {name:'topTemplate', data: viewModel.search}">
	</div>
</script>



<!--Top Songs Page Template-->
<script type="text/html" id="topTemplate"> 
	<div id ="controls">
		<div data-bind="click:viewModel.play" class ="button play">
			<a href = '#'><span class="label">Play Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItemsInfo(2)}" class = "button add">
			<a title="Select Playlist To Add To" class="inline" href="#data" ><span class="label">Add Selected</span></a>
		</div>
	</div>
	<br/>
	<h3>Top Songs</h3>
	<table>
	    <thead><tr>
			<th>Select</th><th>Artist</th><th>Title</th><th>Global Play Count</th><th>Snatched?</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'songListTemplate', foreach: $data.songArr}"></tbody>    
	</table>
</script>

<!--Friends Page Template -->
<script type="text/html" id="fTemplate"> 
	<div data-bind="visible: !viewModel.changedUID()">
		<h3>${$data.first}s Friends</h3>

		<table>
		    <thead><tr>
		        <th style="background:none;"></th><th>Name</th><th>Song Count</th><th>Playlist Count</th><th>Friend Count</th><th>Points</th>
		    </tr></thead>
			<tbody data-bind="template: {name:'friendListTemplate', foreach: $data.friendArr}"></tbody>    
		</table>
	</div>
	<div data-bind="visible: viewModel.changedUID()">
		<div data-bind="template:{name:'pListPageTemplate', data: $data } "></div>
	</div>

</script>

<!-- Friends Table Template -->
<script type="text/html" id="friendListTemplate"> 

    <tr>
        <td><img src=${pic}/></td>
        <td class="no_center">${first} ${last}</td>
        <td>
        	{{if songCount!='0'}}
		       
		        <a data-bind="attr:{value: fid}, click: function() { viewModel.currentUID(fid), viewModel.currentPID($data.pid) }" href = '#'>
		        ${songCount}</a>
		    {{else}}
		        ${songCount}
		    {{/if}}
        </td>
        <td>
        	{{if songCount!='0'}}
	        	<a data-bind="attr:{value: fid}, click: function() { viewModel.currentUID(fid) }" href = '#'>${plistCount}</a>
        	{{else}}
		        ${songCount}
		    {{/if}}
        </td>
        <td>${friendCount}</td>
        <td class='blue'>${points}</td>
    </tr>
	
</script>

<!-- Playlist Page Template -->
<script type="text/html" id="pListPageTemplate"> 
	<div data-bind="visible: !viewModel.changedPID()">
		<h3>${$data.first}s Playlists</h3>
		<div id ="controls">
			<div data-bind="click:viewModel.play_playList" class ="button play">
				<a href = '#'><span class="label">Play Playlist</span></a>
			</div>
			<div data-bind="click: function() { viewModel.lightTemp('addPlistBoxTemp')}, visible: !is_int(viewModel.currentUID())" class = "button add">
				<a title="Enter A Playlist Name" class="inline" href="#data"><span class="label">New Playlist</span></a>
			</div>
	
			<div data-bind="click:function(){viewModel.selectItemsInfo(1)}, visible: !is_int(viewModel.currentUID())" class = "button delete"> 				
				<a title="Delete Playlist(s)?" class="inline" href="#data"><span class="label">Delete Playlist</span></a>
			</div>
			<div data-bind="click: function() { viewModel.lightTemp('addPlistBoxTemp')} ,visible: is_int(viewModel.currentUID())" class = "button add">
				<a title="Enter A Playlist Name" class="inline" href="#data"><span class="label">Copy Playlist</span></a>
			</div>		
		</div>
		
		<br/>
		
		<table>
		    <thead><tr>
		        <th>Select</th><th>Name</th><th>Song Count</th><th>Date Created</th>
		    </tr></thead>
			<tbody data-bind="template: {name:'plistTemplate', foreach: $data.plistArr }"></tbody>    
		</table>
	</div>
	
	
		
		<div data-bind="visible: viewModel.changedPID(), template:{name:'songPageTemplate', data: $data } "></div>
	
</script>


<!-- Playlist Table Templates -->
<script type="text/html" id="plistTemplate"> 
    
    <tr>
    	<td><input type="checkbox" data-bind="attr:{value: id}, checked: viewModel.checkedIDs" /></td>
        <td class="no_center"><a data-bind="attr:{value: id}, click: function() { viewModel.currentPID(id) }" href = '#'>${name}</a></td>

        <td>${count}</td>
        <td><abbr class="timeago" title="${date}"></abbr></td>		
    </tr>
	</script>

<!-- Song Table Templates -->
<script type="text/html" id="songListTemplate"> 
    
    <tr>
        <td><input type="checkbox" data-bind="attr:{value: id}, checked: viewModel.checkedIDs()" /></td>
        <td class="no_center">${artist}</td>
        <td class="no_center">${title}</td>
        <td>${count}</td>
        <td data-bind="visible: $data.date!='6/7/2011'"><abbr class="timeago" title="${date}"></abbr></td>
        <td>
       		<a href='#' class="snatch" data-bind="attr:{id:id}, click: function(){ viewModel.snatch(id) }">
       		
            <img data-bind="attr:{src: viewModel.isSnatched(id) } "/>
            </a>
        </td>	
    </tr>
	
</script>

<!-- Song Page Templates -->

<script type="text/html" id="songPageTemplate"> 
<h3 data-bind="visible: viewModel.changedPID()"><a data-bind="click: function() { viewModel.currentPID('') }" href = '#'>${$data.first} ${$data.last}</a> - ${$data.name} </h3>
	<div id ="controls">
		
		<div data-bind="click:viewModel.play" class ="button play">
			<a href = '#'><span class="label">Play Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItemsInfo(2)}" class = "button add">
			<a title="Select Playlist To Add To" class="inline" href="#data" ><span class="label">Add Selected</span></a>
		</div>
		<div data-bind="click:function(){viewModel.selectItemsInfo(0)}, visible: !is_int(viewModel.currentUID())" class = "button delete">
			<a title="Delete Song(s) From Playlist?" class="inline" href="#data"><span class="label">Delete Selected</span></a>
		</div>

		
		<div  id = "visibility">
			
			See:
			<input type="radio" name="whatever" data-bind="checked: viewModel.viewAll" value="1" /> All
			<input type="radio" name="whatever" data-bind="checked: viewModel.viewAll" value="0" /> My Snatches
			<span data-bind="visible: viewModel.changedUID()"><input type="radio" name="whatever" data-bind="checked: viewModel.viewAll" value="2" />${$data.first}s Snatches</span>
			
		</div>
	</div>
	<br/>
	<table>
	    <thead><tr>
	        <th>Select</th><th>Artist</th><th>Title</th><th>User Play Count</th><th>Date Added</th><th>Snatched?</th>
	    </tr></thead>
		<tbody data-bind="template: {name:'songListTemplate', foreach:viewModel.songsToShow }"></tbody>    
	</table>
</script>


<script type='text/javascript'>
	//Initialize
	var init = <?php echo getLists($user_profile['id']) ?>;
	var user_id=<?php echo $user_profile['id'] ?>;
	var myPlistID = init[0].id;
	var myFirst = init[0].first;
	var myLast= init[0].last;
	
	var player;
	var selSongs; //used to add multiple songs to multiple playlists as a temp array
	var changeName=1;
	
	//Check if integer
	function is_int(value){ 
  		if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
      		return true;
  		} else { 
     		return false;
  		} 
	}
	//Page Class
	var pageObj = function(title,reg_img,alt_img,template) {
	    this.title=title;
	    this.reg_img=reg_img;
	    this.alt_img=alt_img;
	    this.selected_img=ko.observable(reg_img);
	    this.template = ko.observable(template);
	}
	//Song Class
	var song = function(id,artist,title,count,mp3,snatched,date) {
	    this.id=id;
	    this.mp3=mp3;
	    this.artist=artist;
	    this.title=title;
	    this.count=ko.observable(count);
	    this.snatched=snatched;
	    this.date=date;
	}
	//Playlist Class
	var plist = function (id,name,date,count,uid,songs,user_first){
		this.id=id;
		this.name=name;
		this.date=date;
		this.count=count;
		this.uid=uid;
		this.songs=songs;
		this.user_first=user_first;
	}
	
	//All Pages
	var mySongPage = new pageObj('Songs','img/songs.png','img/songs-b.png','songPageTemplate');
	var myPlistPage = new pageObj('Playlists','img/playlists.png','img/playlists-b.png','pListPageTemplate'); 
	var friendPage = new pageObj('Friends','img/friends.png','img/friends-b.png','fTemplate')//,user_id,null);
	var topPage = new pageObj('Top Music','img/topsongs.png','img/topsongs-b.png','topTemplate')//,null,null);
	var searchPage = new pageObj('Search','img/search.png','img/search-b.png','searchTemplate')//,null,null);
	

	//Map URL String to Page Obj
	var page_map = {};
	page_map['Songs'] = mySongPage;
	page_map['Playlists'] = myPlistPage;
	page_map['Friends'] = friendPage;
	page_map['Top Music'] = topPage;
	page_map['Search'] = searchPage;
		
	var viewModel={
		checkedIDs: ko.observableArray(),
		currentPID:ko.observable(),
		currentUID:ko.observable(),
		snatchedIDs:ko.observableArray([]),
		currentPage:ko.observable(),
		myPoints:ko.observable(),
		activities:ko.observableArray([]),
		viewAll : ko.observable('1'),
		//Load Pages
		loadData: function(){
			console.log('load data '+this.selectedPage())
			
			
			switch(this.selectedPage()){
	        	case 'Songs':
	        		this.loadMySongs();
	        		break;
	        	case 'Playlists':
		        	this.loadMyLists();
		        	break;
	        	case 'Search':
	        		break;
	        	case 'Friends':
		        	this.loadFriends(user_id);
		        	break;
	        
	        	default:
	    	    	this.loadTopSongs();
	    	    	break;
			}
		},
		loadMySongs:function(){
			this.loadSongsByPid(myPlistID)
		},
		loadMyLists:function(){
			this.loadPlaylistsByUid(user_id);
		},
		loadSongsByPid: function(pid){
			var type=0;
	   		if(pid==myPlistID)
	   			type=1;
			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getSongsWithURL&pid="+pid,
				dataType:'json',
				success: function(msg) {
					if(viewModel.dataObj.songArr().length>0)
						viewModel.dataObj.songArr.removeAll();

					viewModel.songFactory(msg,viewModel.dataObj.songArr,type);
				}
			});

	   	},
	   	loadOneList:function(pid){
	   		var type=0;
	   		if(pid==myPlistID)
	   			type=1;
	   		$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getOneList&pid="+pid,
				dataType:'json',
				success: function(msg) {
					viewModel.dataObj.songArr.removeAll();
					viewModel.dataObj.first(msg.first)
					viewModel.dataObj.last(msg.last)
					viewModel.dataObj.name(msg.name)
					console.log('loadonelist pid below')
					console.log(pid)
					viewModel.songFactory(msg.tracks,viewModel.dataObj.songArr,type)
		
				}
			})	
		},
	   	
		loadPlaylistsByUid:function(usid){

	   		$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getListURL&uid="+usid,
				dataType:'json',
				success: function(msg) {

					if(viewModel.dataObj.plistArr().length>0)
						viewModel.dataObj.plistArr.removeAll();
					
					var d =ko.utils.arrayMap(msg, function(playlist) {
						if(changeName==1){
							viewModel.dataObj.first(playlist.first);
							viewModel.dataObj.last(playlist.last);
						}
						
   		 				viewModel.dataObj.plistArr.push(new plist(playlist.id,playlist.name, playlist.date, playlist.song_count,playlist.uid,playlist.tracks,playlist.first));
					});
					changeName=1
				}
			})	
		},
		loadFriends:function(usid){
			
			
			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getFriends&uid="+usid,
				dataType:'json',
				success: function(msg) {
					console.log('load friends' +usid)
					console.log(msg)					
		
					viewModel.dataObj.friendArr.removeAll();
					if(!is_int(viewModel.currentUID())){
						viewModel.dataObj.first(msg.myfirst);
						viewModel.dataObj.last(msg.mylast);
					}
					var d =ko.utils.arrayMap(msg.friends, function(friends) {
   		 				viewModel.dataObj.friendArr.push(friends);
					})
				},
				error:function(msg){
					console.log(msg)
				}
			})
		},
		loadTopSongs:function(){
			
			$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=getTopSongs",
				dataType:'json',
				success: function(msg) {
					viewModel.dataObj.songArr.removeAll();
					viewModel.songFactory(msg,viewModel.dataObj.songArr, 0 )
				}
			});

		},

		
		pages: ['Songs','Playlists','Friends','Top Music', 'Search'],
		songFactory:function(data, song_arr, type){ //Create song objects from JSON
			if(type==1)
				viewModel.snatchedIDs.removeAll();
			for(var i=0;i<data.length;i++){
				if(type==1 && data[i].snatched==1)
					viewModel.snatchedIDs().push(data[i].id)
				song_arr.push(new song(data[i].id,data[i].artist,data[i].title,data[i].count,data[i].mp3,data[i].snatched,data[i].date))
			}
		},
		selectPage: function(page){
			this.search.songArr.removeAll();
			this.currentUID(null);
			this.currentPID(null);
			this.checkedIDs.removeAll();
			this.searchTerm("");
			this.viewAll('1')
			getMyPoints();
			if(page!=this.selectedPage()){
				this.selectedPage(page);
				
			}
		},
		selectedPage:ko.observable('Songs'),
		
	}
	viewModel.switchPage=function(pagetype){
		viewModel.currentPage().selected_img(viewModel.currentPage().reg_img); 
		viewModel.selectPage(pagetype); 
		viewModel.currentPage().selected_img(viewModel.currentPage().alt_img)
	}
	viewModel.dataObj = {
		first : ko.observable(myFirst),
		last : ko.observable(myLast),
		name : ko.observable(),
		plistArr : ko.observableArray(),
		songArr : ko.observableArray(),
		
		friendArr: ko.observableArray()		
	};
	ko.dependentObservable(function() {
		this.currentPage(page_map[this.selectedPage()]);
		this.loadData();	
	},viewModel)
	
	viewModel.changedPID = ko.dependentObservable(function() {
		var pid = this.currentPID();
    	if(is_int(pid)){
    		console.log('changed pid '+pid)
    		this.loadOneList(pid)
			return this.dataObj
		}
	    else{	
	    	console.log('pid is not int '+pid)
	    	return viewModel.loadData()
	    }
	}, viewModel);
	
	viewModel.changedUID = ko.dependentObservable(function() {
		var uid = this.currentUID();
    	if(is_int(uid)){
    		console.log('changed uid '+uid)
    		this.loadPlaylistsByUid(uid)
			return this.dataObj
		}
	    else{	
	    	console.log('uid is not int '+uid)
	    	return viewModel.loadData();
	    }
	}, viewModel);
	
	//Search Functionality
	viewModel.search = {
		songArr:ko.observableArray([])
	}
    viewModel.query =function() {

    	if(viewModel.searchTerm()){
	    	$.ajax({
				type: "GET",
				url: "php/getData.php",
				data:"f=search&query="+viewModel.searchTerm(),
				dataType:'json',
				success: function(msg) {
					viewModel.search.songArr.removeAll(); 
					viewModel.songFactory(msg,viewModel.search.songArr,0);
				},
				error:function(msg){
					console.log(msg)
				}
			})
		}	
    }
    viewModel.searchTerm = ko.observable();
	viewModel.runSearch = ko.dependentObservable(function () {   
    		this.query()
    },viewModel);
	
	
	//Display My Snatches
	viewModel.songsToShow = ko.dependentObservable(function () {      
		// Represents a filtered list of planets
		// i.e., only those matching the "typeToShow" condition
		var desiredType = this.viewAll();
		if (desiredType == "1")
		    return this.dataObj.songArr();
		else if(desiredType=='2')
			return ko.utils.arrayFilter(this.dataObj.songArr(), function(song) {
        		return song.snatched == 1;
    		});

		else{
			var lists=new Array();
			ko.utils.arrayForEach(viewModel.snatchedIDs(), function(item) {
				lists.push(ko.utils.arrayFirst(viewModel.dataObj.songArr(), function(song) {
	    			return song.id ==item;
				}));
			})
			var lists2=new Array();
			ko.utils.arrayForEach(lists, function(song){
				if(song)
					lists2.push(song)
			})
			return lists2;
		}

	}.bind(viewModel));
	
    //Snatch Functionality
    
	viewModel.isSnatched=function(songid){ //Returns snatch/unsnatched image
		if(ko.utils.arrayFirst(viewModel.snatchedIDs(), function(item) {
    		return (item==songid)
		}))
			return 'img/snatches-b.png'
		else
		
			return 'img/snatches.png'
    }

    viewModel.snatch=function(songid){ // Adds/Removes from Snatched Array
       	var type=1;
    	if(viewModel.snatchedIDs().length>0)
	    	if(ko.utils.arrayFirst(viewModel.snatchedIDs(), function(item) {
 				return item==songid
	    	})){
	    		viewModel.snatchedIDs.remove(songid)
	    		type=0;
	    	}
	    	else
	    		viewModel.snatchedIDs.push(songid)
	    else{
	 	    viewModel.snatchedIDs.push(songid)
	    }
	    updateSnatch(songid,type)
	    if(type==1)
	    	saveSnatchActivity(songid)
	    
    }
  
    updateSnatch=function(sid,type){ //Updates snatch status in DB
    	
       		
       	$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=updateSnatch&sid="+sid+"&type="+type+"&pid="+myPlistID,
			dataType:'json',
			success: function(msg) {
				
			},
			error:function(msg){
				console.log(msg)
			}
		})

    }
    
    //Controls
    viewModel.listToAdd = ko.observable("");
    viewModel.lightTemp = ko.observable("addPlistBoxTemp")
    
    viewModel.addList = function () {
		
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=newPList&uid="+user_id+"&name="+viewModel.listToAdd(),
			success: function(msg) {
				viewModel.loadData();
				$.fancybox.close();
			}
		})
	}
	
	viewModel.addToList = function () {
		var str = viewModel.checkedIDs().join('^');
		var song_str = selSongs.join('^');
		selSongs=[];
		viewModel.checkedIDs.removeAll();

		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=saveToPlayList&pid="+str+"&sid="+song_str,
			success: function(msg) {
				console.log(msg)
				if(viewModel.currentPage().title=='Songs')
					viewModel.loadData()
				else if(viewModel.currentPage().title=='Playlists')
					viewModel.loadSongsByPid(viewModel.currentPID())
				$.fancybox.close();
			}
		})
	}
	viewModel.delSongConfirm = function () {
		var str = viewModel.checkedIDs().join('^');
		var pid = myPlistID
		if(is_int(viewModel.currentPID()))
			pid=viewModel.currentPID()
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=delSongs&pid="+pid+"&sid="+str,
			success: function(msg) {
				console.log(msg)
				viewModel.checkedIDs.removeAll();
				viewModel.loadSongsByPid(pid);
				$.fancybox.close();
			},
			error: function(msg){

			}
		})	
	}

	viewModel.delListConfirm = function () {
		var str = viewModel.checkedIDs().join('^');
		
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=delPlaylist&pid="+str,
			success: function(msg) {
				viewModel.checkedIDs.removeAll();
				viewModel.loadData();
				$.fancybox.close();
			},
			error: function(msg){
			
			}
		})	
	}
	
	
	//Create Selected Item Info
	viewModel.selItemsName = ko.observableArray();
	viewModel.selectItemsInfo = function(type){
		if(viewModel.checkedIDs().length > 0){
			viewModel.selItemsName.removeAll();
			var selected_arr=viewModel.checkedIDs();
			var item_arr=viewModel.dataObj.songArr();
			
			if(type=='1'){
				viewModel.lightTemp('delPlistBoxTemp');
				item_arr=viewModel.dataObj.plistArr();
			}
			else if(type=='2'){
				
				selSongs=viewModel.checkedIDs();
				selected_arr=selSongs;
				changeName=0;
				viewModel.checkedIDs.removeAll();
				viewModel.loadPlaylistsByUid(user_id);
				viewModel.lightTemp("addSongBoxTemp")	
			}
			else
				viewModel.lightTemp('delSongBoxTemp');


			ko.utils.arrayForEach(selected_arr, function(id){
				
				var itemToEdit=ko.utils.arrayFirst(item_arr, function(item){
					return item['id']==id
				})
				if(type=='1')
					viewModel.selItemsName.push(itemToEdit['name'])
				else
					viewModel.selItemsName.push(itemToEdit['title']+" - "+itemToEdit['artist'])
			})	
		}			
		else{
			viewModel.lightTemp('errBoxTemp');	
		}
	}
	
	//Playsongs
	viewModel.play = function(){
		ko.utils.arrayForEach(viewModel.checkedIDs(), function(item) {
			//console.log('item '+item)
			var songToPlay=ko.utils.arrayFirst(viewModel.dataObj.songArr(), function(song){
		
				return song['id']==item
			})
			player.add(songToPlay)
			
		})
		dispTrash();
		viewModel.checkedIDs.removeAll()
	}
	
	viewModel.play_playList=function(){
    	var lists=[];
    	ko.utils.arrayForEach(viewModel.checkedIDs(), function(item) {
			lists.push(ko.utils.arrayFirst(viewModel.dataObj.plistArr(), function(plist) {
	    		return plist.id ==item;
			}));
		})
		
		ko.utils.arrayForEach(lists, function(plist){

			saveListActivity(plist.id,plist.name,plist.uid,plist.user_first)			
			ko.utils.arrayForEach(plist.songs, function(song){
				console.log(song.title)
				player.add(song)	
			})
		})
		dispTrash();
    }
    //Increment Playcount
    viewModel.updatePlayCount=function(sid){
    	$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=updatePlayCount&pid="+myPlistID+"&sid="+sid,
			success: function(msg) {
				
			
			},
			error: function(msg){

			}
		})
		
    }
    
    
    //Activities
	var lastActID=0;
	function loadActivities(){
		$.ajax({
			type: "GET",
			url: "php/getData.php",
			data:"f=getActivities&uid="+user_id+"&lastid="+lastActID,
			success: function(msg) {
				var data = jQuery.parseJSON( msg );
				for(i=0;i<data.length;i++)
					viewModel.activities.push(data[i]);
			},
			error: function(msg){

			}
		})
	}
	
	//Save Activity
	function saveListActivity(pid,title,plist_user,first){
		console.log('save list ' +pid)
		if(plist_user!=user_id)
			title=first+"s "+title;
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=saveListActivity&uid="+user_id+"&pid="+pid+"&puser="+plist_user+"&first="+myFirst+"&last="+myLast+"&title="+title+"&type=2",
			success: function(msg) {
			},
			error: function(msg){
				console.log(msg)
			}
		})
	}
	function saveSongActivity(artist,title,id){
		
		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=saveSongActivity&uid="+user_id+"&sid="+id+"&first="+myFirst+"&last="+myLast+"&artist="+artist+"&title="+title+"&type=1",
			success: function(msg) {
			},
			error: function(msg){
				console.log(msg)
			}
		})
	}
   	function saveSnatchActivity(sid){
   		var songToEdit=ko.utils.arrayFirst(viewModel.dataObj.songArr(), function(song){
				return song['id']==sid
		})
		//console.log(songToEdit)
   		var artist=songToEdit.artist;
   		var title=songToEdit.title;
   		//console.log('title '+title)
   		$.ajax({
			type: "GET",
			url: "php/saveData.php",
			data:"f=saveSongActivity&uid="+user_id+"&sid="+sid+"&first="+myFirst+"&last="+myLast+"&artist="+artist+"&title="+title+"&type=3",
			success: function(msg) {
			},
			error: function(msg){
				console.log(msg)
			}
		})
   	}
    //Points
	function getMyPoints(){
		$.ajax({
			type: "GET",
			url: "php/getData.php",
			data:"f=getMyPoints&uid="+user_id,
			success: function(msg) {
				viewModel.myPoints(msg)
			},
			error: function(msg){

			}
		})
	}

    
    //Doc Ready
	$(document).ready(function(){
		
		ko.applyBindings(viewModel);  	
 		ko.linkObservableToUrl(viewModel.selectedPage, "page",'Songs' ); 	
 		ko.linkObservableToUrl(viewModel.currentUID, "uid");			
		ko.linkObservableToUrl(viewModel.currentPID, "pid");	
		ko.linkObservableToUrl(viewModel.searchTerm, "query");	
		getMyPoints()
		loadActivities()
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
		$("abbr.timeago").livequery(function(){
			$(this).timeago();
		})

		
		//JPlayer
		player = new jPlayerPlaylist({
			jPlayer: "#jquery_jplayer_1",
			cssSelectorAncestor: "#jp_container_1"
		}, "",
		{
			swfPath: "js",
			supplied: "mp3",
			oggSupport: false,
			mode: "window",
			playlistOptions: {
				shuffleTime: 'fast',
    			enableRemoveControls: true,
    			autoPlay: 'true'
  			},
		});
		
		//Clear Queue Button
		$(".jp-gui.jp-interface").after('<p id="clearqueue"><button onclick="javascript:clearQueue()">Clear Queue</button></p>')
	
		$("#jquery_jplayer_1").jPlayer().bind($.jPlayer.event.play, function(event) { // Add a listener to report song id
			viewModel.updatePlayCount(player.playlist[player.current].id)
			var songToEdit=ko.utils.arrayFirst(viewModel.dataObj.songArr(), function(song){
				return song['id']==player.playlist[player.current].id
			})
			var a = parseInt(songToEdit.count());
			a++

			songToEdit.count(a);
			
			saveSongActivity(songToEdit.artist,songToEdit.title,songToEdit.id);
		})
	});
	
	function clearQueue(){
		player.remove();
	}

	function dispTrash(){
		if(player.playlist.length>0 && !$('#clearqueue').is(":visible") ){
			player.play()
		
			$('#clearqueue').show();
		}	
		else if(player.playlist.length==0){
		
			$('#clearqueue').hide();
		}
	}
	
	//Signout
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
		<tbody data-bind="template: {name:'plistTemplate', foreach: viewModel.dataObj.plistArr}"></tbody>    
		</table>
		<button data-bind="click: function() {$.fancybox.close()}">Cancel</button>
		<button type="submit" data-bind="enable: viewModel.checkedIDs().length > 0">Add</button>
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


<script type="text/html" id="errBoxTemp"> 
	Please select at least
	<br/>
	<em>one</em> item to delete:
	<br/>
	<br/>
	<button data-bind="click: function() {$.fancybox.close()}">Close</button>
</script>

 
<script type="text/html" id="activityTemplate">
	<li>
	<div>
		<span class = 'name'><a data-bind="click: function() { viewModel.switchPage('Friends'); viewModel.currentUID($data.uid) }" href='#'>${first} ${last}</a></span><br/>
		
		{{if type=='0'}}
			<span class = 'action'>joined</span><br/>
			<span class = 'item'><a href='#'>Song Snatch</a></span><br/>
		{{else type=='1'}}
			<span class = 'action'>listened to the song</span><br/>
			<span class = 'item'><a data-bind="click: function() { viewModel.switchPage('Search'); viewModel.searchTerm($data.title)}" href='#'>${artist} - ${title}</a></span><br/>
		{{else type=='2'}}
			<span class = 'action'>listened to the playlist</span><br/>
			
				{{if $data.puser==user_id}}
					<span class = 'item'><a data-bind="click: function() { viewModel.switchPage('Playlists'); setTimeout(function() { viewModel.currentPID($data.pid);},400)}" href='#'>${title}</a></span><br/>
				{{else}}
					<span class = 'item'><a data-bind="click: function() { viewModel.switchPage('Friends'); setTimeout(function() { viewModel.currentUID($data.puser)}, 200);setTimeout(function() { viewModel.currentPID($data.pid);},400)}" href='#'>${title}</a></span><br/>
				{{/if}}
		{{else type=='3'}}
			<span class = 'action'>snatched</span><br/>
			<span class = 'item'><a data-bind="click: function() { viewModel.switchPage('Search'); viewModel.searchTerm($data.title)}" href='#'>${artist} - ${title}</a></span><br/>
	    {{else}}
	        ${type}
	    {{/if}}

				
		
		
		<span class="date"><abbr class="timeago" title="${date}"></abbr></span>
	</div>
	</li>
</script>

