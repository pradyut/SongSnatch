<?php 
	
	function query($query){
		//Connecting to DB
		$db = "localhost";
		$un = "plugmeup";
		$pw = "plugmeup1";
		$dbname = "plugdb_song";
		if($dbc = mysql_connect( $db, $un, $pw ));
		mysql_select_db($dbname, $dbc)
		  or die( "Error! Could not select the database: " . mysql_error());
		
		return mysql_query($query, $dbc);
	}
	
	
?>