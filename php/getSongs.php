<?php
	$id=$_GET['uid'];
	
	//Connecting to DB
	$db = "localhost";
	$un = "plugmeup";
	$pw = "plugmeup1";
	$dbname = "plugdb_song";
	if($dbc = mysql_connect( $db, $un, $pw ));
	mysql_select_db($dbname, $dbc)
	  or die( "Error! Could not select the database: " . mysql_error());
	
	$query = "SELECT * from songs";
	$result = mysql_query($query, $dbc);
	
	$response = array('ID'=>'', 'title'=>'', 'artist'=>'','URL'=>'');
	$res = array();
	while($row = mysql_fetch_row($result)) {
		$response['ID']=$row[0];
		$response['title']=$row[1];
		$response['artist']=$row[2];
		$response['URL']=($row[3]);
		$res[] =  $response;
	}
	
	print json_encode($res)


?>