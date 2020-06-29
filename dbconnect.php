<?php
	$db=mysqli_connect("mysql-server","db-user","db-password","db-name");
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
		die();
	}
	mysqli_set_charset($db, "utf8");
?>