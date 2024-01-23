<?php

	include 'authent.php';

	$eventname = $_POST['eventname'];
	$eventdate = $_POST['eventdate'];

	include 'db.php';
	
	$db = db_connect();
  	
	// show event
	$db->query("INSERT OR IGNORE INTO usertable(username, eventdate, eventname, show) VALUES('$username', '$eventdate', '$eventname', 1)");
	$db->query("UPDATE usertable SET eventdate='$eventdate', eventname='$eventname', show=1 WHERE username='$username'");
			
	db_disconnect($db)
	
?>
