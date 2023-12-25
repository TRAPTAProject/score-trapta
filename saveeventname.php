<?php
    $eventname = "Tir non nommé";
    if (isset($_POST['eventname'])) $eventname = $_POST['eventname'];
    $cleanedString = preg_replace('/[^a-zA-Z0-9\s-]/', '', $eventname);
    $eventnameFile = fopen("eventname.txt","w");
    fwrite($eventnameFile,$cleanedString);
    fclose($eventnameFile);
