<?php
	include_once("utils.php");
	if(isset($_GET['f'])){
  		$_GET['f']();
	}
	function saveToPlayList(){
		$sids = explode('^', $_GET['sid']);
		$pids = explode('^', $_GET['pid']);
		$sql = array(); 
		foreach( $pids as &$value ) {
			foreach( $sids as &$val ) {
	    		$sql[] = '("'.$value.'", "'.$val.'")';
	    	}
		}
		$query = "INSERT into `playlist_songs` (`play_id`, `song_id`) VALUES ".implode(',', $sql); 
		query($query);
	}

	function delSongs(){
		$sids = explode('^', $_GET['sid']);
		$params = "'".implode("','",$sids)."'";
		query(vsprintf("DELETE from `playlist_songs` WHERE play_id = '".$_GET['pid']."' AND song_id in (%s)",$params));
	}
	function delPlaylist(){
		$pids = explode('^', $_GET['pid']);
		$params = "'".implode("','",$pids)."'";
		query(vsprintf("DELETE from `playlists` WHERE ID in (%s)",$params)); 

	}
	function createPlaylist($name,$uid){
		if($name =='Song History')
			$query = "INSERT INTO `playlists` (name, user_id,history) VALUES('".$name."','".$uid."','1')";
		else
			$query = "INSERT INTO `playlists` (name, user_id) VALUES('".$name."','".$uid."')";
		query($query);
	}
	function newPList(){
		if(isset($_GET['uid'])){
			createPlaylist($_GET['name'],$_GET['uid']);
		}
	}
	
	function isSongInHistory($pid,$sid){
		$result = query("SELECT * FROM playlist_songs WHERE song_id=".$sid." AND play_id=".$pid);
		$number_of_rows = mysql_num_rows($result);
		
		if ($number_of_rows == 0)
		{
		 	saveToPlayList();
		}
	}
	
	function rewardUser($sid,$pid){

		$result = query("SELECT rewarded FROM playlist_songs WHERE song_id=".$sid." AND play_id=".$pid);
		$row = mysql_fetch_row($result);
	
		if($row[0]==0){
	
			query("UPDATE playlist_songs SET rewarded=1 Where song_id=".$sid." AND play_id=".$pid);
			$query="UPDATE users SET points=points+1 Where users.ID=(select user from songs WHERE songs.ID=".$sid.")";

			query($query);

		}
	}
	
	function updateSnatch(){
		$pid=$_GET['pid'];
		$sid=$_GET['sid'];

		isSongInHistory($pid,$sid);
		$query = "UPDATE `playlist_songs` SET snatched=".$_GET['type']." WHERE song_id=".$sid." AND play_id=".$pid;
		query($query);
		if($_GET['type']==1)
			rewardUser($sid,$pid);
	}
	
	function updatePlayCount(){
		$pid=$_GET['pid'];
		$sid=$_GET['sid'];
		isSongInHistory($pid,$sid);
		$query = "UPDATE playlist_songs SET count=count+1 Where song_id=".$sid." AND play_id=".$pid;
		query($query);
		$query2 = "UPDATE songs SET count=count+1 Where ID=".$sid;
		query($query2);
	}
	
	
	function saveSongActivity(){
		$uid=$_GET['uid'];
		$sid=$_GET['sid'];
		$type=$_GET['type'];
		$first=$_GET['first'];
		$last=$_GET['last'];
		$artist=$_GET['artist'];
		$title=$_GET['title'];
		$query = "INSERT INTO `feed` (uid, sid,type,first,last,artist,title) VALUES('".$uid."','".$sid."','".$type."','".$first."','".$last."','".$artist."','".$title."')";
		query($query);
	}
	function saveListActivity(){
		$uid=$_GET['uid'];
		$pid=$_GET['pid'];
		$type=$_GET['type'];
		$first=$_GET['first'];
		$last=$_GET['last'];
		$puser=$_GET['puser'];
		$title=$_GET['title'];
		$query = "INSERT INTO `feed` (uid, pid,type,first,last,puser,title) VALUES('".$uid."','".$pid."','".$type."','".$first."','".$last."','".$puser."','".$title."')";
		query($query);
	
	}
	?>