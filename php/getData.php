<?php
	include_once("utils.php");
	if(isset($_GET['f'])){
  		$_GET['f']();
	}
	function getListURL(){
		if(isset($_GET['uid'])){
			getLists($_GET['uid']);
		}
	}
	function getSongsWithURL(){
		if(isset($_GET['pid'])){
			print getSongsWithParams($_GET['pid']);
		}
	}
	
	function getMyPoints(){
		$result = query("SELECT points from users WHERE ID=".$_GET['uid']);
		$row = mysql_fetch_row($result);
		print $row[0];
	}
	function getOneList(){
		$query = "SELECT  `playlists`.`ID` ,  `name` ,  `date` ,  `users`.`first_name` ,  `users`.`last_name` ,`history`, `snatches`, user_id FROM playlists, users WHERE  `playlists`.`ID` =".$_GET['pid']." AND `users`.ID=`playlists`.`user_id` ORDER BY  `date` ASC"; 
		$response = array('id'=>'','name'=>'','date'=>'','song_count'=>'','first'=>'','last'=>'', 'tracks'=>'', 'history'=>'', 'snatches'=>'','uid'=>'');
		$result = query($query);
		
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['name']=$row[1];
			$response['date']=$row[2];
			$response['first']=$row[3];
			$response['last']=$row[4];
			$response['history']=$row[5];
			$response['snatches']=$row[6];
			$response['tracks']=json_decode(getSongsWithParams($row[0]));
			$response['song_count']=sizeof($response['tracks']);
			$response['uid']=$row[7];
			
		}
		
		print json_encode($response);
	}
	function getLists($uid){
		
		$query = "SELECT `playlists`.`ID`, `name`, `date`, `users`.`first_name`, `users`.`last_name`, `history` , `snatches` FROM playlists, users WHERE user_id = ".$uid." and `users`.`ID`= ".$uid." ORDER BY `date` ASC";
		$response = array('id'=>'','name'=>'','date'=>'','song_count'=>'','first'=>'','last'=>'', 'tracks'=>'', 'history'=>'', 'snatches'=>'','uid'=>'');
		$result = query($query);
		$res=array();
		
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['name']=$row[1];
			$response['date']=$row[2];
			$response['first']=$row[3];
			$response['last']=$row[4];
			$response['history']=$row[5];
			$response['snatches']=$row[6];
			$response['tracks']=json_decode(getSongsWithParams($row[0]));
			$response['song_count']=sizeof($response['tracks']);
			$response['uid']=$uid;
			$res[]= $response;

		}
		
		print json_encode($res);
	}
	function getSongsWithParams($playid) {
	
		$query = "SELECT `ID`,`artist`,`title`,`mp3`,`date`, `playlist_songs`.`count`, `playlist_songs`.`snatched`, `songs`.count, `playlist_songs`.order FROM `songs`, `playlist_songs` WHERE `play_id` = ".$playid." AND `songs`.ID =`song_id` ORDER BY `order` DESC"; 
		$result = query($query);
		
		$response = array('id'=>'', 'oga'=>'', 'title'=>'', 'artist'=>'','mp3'=>'','count'=>'','snatched'=>'','global_count'=>'','date'=>'', 'order'=>'');
		$res = array();
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['title']=$row[2];
			$response['artist']=$row[1];
			$response['mp3']=($row[3]);
			$response['date']=$row[4];
			$response['count']=getCount($row[0],$playid);
			$response['snatched']=($row[6]);
			$response['global_count']=($row[7]);
			$response['order']=($row[8]);
			$response['oga']="http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg";
			$res[] =  $response;
		}
		return json_encode($res);
	}
	
	function getCount($sid,$pid){
		
		$query2 = "SELECT playlists.`ID` from playlists WHERE history = 1 AND user_id = (select user_id from playlists WHERE ID=".$pid.")";
		$result2=query($query2);
		$row2=mysql_fetch_row($result2);
		$hist_id=$row2[0];
		$query = "SELECT count from playlist_songs WHERE play_id=".$hist_id." AND song_id=".$sid;
		$result=query($query);
		$row=mysql_fetch_row($result);
		//echo $query;
		//echo var_dump($row);
		return $row[0];
		
		
	
	}
	function getTopSongs() {
		$query = "SELECT * FROM `songs` ORDER BY `count` DESC LIMIT 10";
		$result = query($query);
		
		$response = array('id'=>'', 'oga'=>'', 'title'=>'', 'artist'=>'','mp3'=>'','count'=>'','global_count'=>'','date'=>'6/7/2011');
		$res = array();
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['title']=$row[1];
			$response['artist']=$row[2];
			$response['mp3']=($row[3]);
			$response['count']=($row[4]);
			$response['global_count']=($row[4]);
			$response['oga']="http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg";
			$res[] =  $response;

		}
		
		if(isset($_GET['mob']))
			print json_encode($res);
		else
			echo json_encode($res);
	}
	
	function search(){
		$query = 'SELECT * FROM `songs` WHERE `title` LIKE "%'.$_GET['query'].'%" OR `artist` LIKE "%'.$_GET['query'].'%"';
		$result = query($query);
		
		$response = array('id'=>'', 'oga'=>'', 'title'=>'', 'artist'=>'','mp3'=>'','count'=>'','global_count'=>'','date'=>'6/7/2011');
		$res = array();
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['title']=$row[1];
			$response['artist']=$row[2];
			$response['mp3']=($row[3]);
			$response['count']=($row[4]);
			$response['global_count']=($row[4]);
			$response['oga']="http://www.jplayer.org/audio/ogg/Miaow-01-Tempered-song.ogg";
			$res[] =  $response;

		}
		print json_encode($res);
	}
	function getFriends(){
		$uid = $_GET['uid'];
		$query = "SELECT pic, first_name,last_name,user_id,friend_id,points FROM `users`,`user_friends` where user_friends.user_id =".$uid." and `users`.id=`user_friends`.friend_id";
		$result = query($query);
		$response = array('pic'=>'', 'first'=>'', 'last'=>'','uid'=>'','fid'=>'','plistCount'=>'','friendCount'=>'','songCount'=>'','points'=>'','pid'=>'');
		$res = array();
		$res['myfirst']="sdfds";
		$res['mylast']="lastsdfds";
		$res['friends']=array();
		while($row = mysql_fetch_row($result)) {
			$response['pic']=$row[0];
			$response['first']=$row[1];
			$response['last']=$row[2];
			$response['uid']=$row[3];
			$response['fid']=$row[4];
			$response['points']=$row[5];
			$response['plistCount']=mysql_num_rows(query("SELECT name from playlists WHERE user_id = ".$row[4]));
			$response['friendCount']=mysql_num_rows(query("SELECT friend_id from user_friends WHERE user_id = ".$row[4]));
			$a = "SELECT ID from playlists WHERE history = 1 AND user_id=".$row[4]; 
			
			$aa = mysql_fetch_row(query($a));
			//echo $a;
			//echo var_dump($aa);
			$q = "SELECT count from playlist_songs WHERE play_id = ".$aa[0];
			$response['pid']=$aa[0];
			//echo $q;
			//echo mysql_num_rows(query($q));
			$response['songCount']=mysql_num_rows(query($q));
			$res['friends'][] =  $response;
		}
		$query2 = "SELECT first_name,last_name FROM `users` where `ID` = ".$uid;
		$result = query($query2);
		while($row = mysql_fetch_row($result)) {
			$res['mylast']=$row[1];
			$res['myfirst']=$row[0];
		}		
		print json_encode($res);
	}
	
	
	function getActivities(){
		$uid=$_GET['uid'];
		$lastid=$_GET['lastid'];
		
		
		$query="SELECT `feed`.ID,uid,date,pid,first,last,sid,type,artist,title,puser FROM `feed`,`user_friends` where user_friends.user_id = ".$uid." and `feed`.uid=`user_friends`.friend_id AND `feed`.ID > ".$lastid." ORDER BY ID DESC LIMIT 10";
		
		$result = query($query);
		
		$response = array('id'=>'', 'uid'=>'', 'title'=>'', 'artist'=>'', 'first'=>'', 'last'=>'', 'sid'=>'', 'pid'=>'', 'date'=>'', 'type'=>'','puser'=>'');
		$res = array();
		while($row = mysql_fetch_row($result)) {
			$response['id']=$row[0];
			$response['title']=$row[9];
			$response['puser']=$row[10];
			$response['artist']=$row[8];
			$response['pid']=($row[3]);
			$response['date']=$row[2];
			$response['last']=$row[5];
			$response['first']=$row[4];
			$response['uid']=($row[1]);
			$response['type']=($row[7]);
			$response['sid']=($row[6]);
			//echo var_dump($response);
			$res[] =  $response;
		}
		//echo $res;
		print json_encode($res);
		
	}
?>