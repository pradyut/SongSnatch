<?php
	include_once("utils.php");
	include_once("saveData.php");

	function checkUser($profile){
		$query = "SELECT * FROM `users` WHERE ID =".$profile['id'];
		$result = query($query);
		$num_rows = mysql_num_rows($result);
		if($num_rows == 0){
			addUser($profile['id'],$profile['first_name'],$profile['last_name'],"https://graph.facebook.com/".$profile['id']."/picture");
		}
		else
			updateFriends($profile['id']);
		
	}
	function addUser($uid,$first,$last,$pic){
		$query = "INSERT INTO users (ID, first_name, pic,last_name) VALUES('".$uid."','".$first."','".$pic."','".$last."')";
		query($query);
		updateFriends($uid);
		createPlaylist("Song History", $uid);
	}
	
	
	
	function updateFriends($uid){
		
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
			
			checkFriend($uid,$response[$i]['uid']);
		}
	}
	function checkFriend($uid,$fid){
		$query = "SELECT * FROM `user_friends` WHERE user_id =".$uid." AND friend_id=".$fid;

		$result = query($query);
		$num_rows = mysql_num_rows($result);
		if($num_rows == 0){
			$q = "INSERT into `user_friends` (user_id,friend_id) VALUES('".$uid."','".$fid."')";
			query($q);
		}
	}


?>