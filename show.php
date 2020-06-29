<?php
	$password = "";
	$username = "";
	if (isset($_POST['password'])) $password = $_POST['password'];
	if (isset($_POST['username'])) $username = $_POST['username'];
	if ($password=="" || $username=="") {
		header('HTTP/1.0 401 Unauthorized');
		die();
	}
	if (!isset($_POST['eventname']) || !isset($_POST['eventdate'])) {
		header('HTTP/1.0 400 Bad Request');
		die();
	}
	$eventname = $_POST['eventname'];
	$eventdate = $_POST['eventdate'];

	include 'dbconnect.php';
  	
  	$result = mysqli_query($db,"SELECT * FROM `usertable` WHERE `username`='".$username."'");
	if ($row = mysqli_fetch_array($result)) {

		if ($row['password']==$password) {
			// show event
			mysqli_query($db,"UPDATE `usertable` SET `eventdate`='".$eventdate
				."', `eventname`='".$eventname
				."', `show`=1 WHERE `username`='".$username."'");
			
		}
		else {
			header('HTTP/1.0 401 Unauthorized');
		}
	}
	else {
		header('HTTP/1.0 401 Unauthorized');
	}
	include 'dbdisconnect.php';
	
?>
