<?php
	$password = "";
	$username = "";
	if (isset($_POST['password'])) $password = $_POST['password'];
	if (isset($_POST['username'])) $username = $_POST['username'];
	if ($password=="" || $username=="") {
		header('HTTP/1.0 401 Unauthorized');
		die();
	}
	include 'dbconnect.php';
  	$result = mysqli_query($db,"SELECT * FROM `usertable` WHERE `username`='".$username."'");
	if ($row = mysqli_fetch_array($result)) {

		if ($row['password']==$password) {
			// hide event
			mysqli_query($db,"UPDATE `usertable` SET `show`=0 WHERE `username`='".$username."'");

			$file = fopen($username."/ranking.html","w");
			fwrite($file, "Pas d'information sur le classement individuel.");
			fclose($file);	
			$file = fopen($username."/positions.html","w");
			fwrite($file, "Pas d'information sur les positions.");
			fclose($file);	
			$file = fopen($username."/matches.html","w");
			fwrite($file, "Pas d'information sur les matches.");
			fclose($file);	
			$file = fopen($username."/teams.html","w");
			fwrite($file, "Pas d'information sur le classement par équipe.");
			fclose($file);	
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
