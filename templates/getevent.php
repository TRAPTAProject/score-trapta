<?php

    $username = basename(getcwd());
	$eventname = "Event name";

	include '../../dbconnect.php';
  	$result = $db->query("SELECT * FROM `usertable` WHERE `username`='".$username."'");
  	$eventname = "Event";
  	$date = "Date";
	if ($row = $result->fetchArray()) {
		$eventname = $row['eventname'];
		$date = $row['eventdate'];
	}
	include '../../dbdisconnect.php';
    
?>