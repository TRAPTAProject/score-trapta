<?php
    $eventname = "Tir non nommé";
	if (isset($_POST['eventname'])) $eventname = $_POST['eventname'];
    $eventname = substr(preg_replace('/{}();:,.=@#$/', '', $eventname), 50);
    $eventnameFile = fopen("eventname.txt","w");
	fwrite($eventnameFile,$eventname);
	fclose($eventnameFile);
