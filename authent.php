<?php


    include 'conf.php';

    $_password = "";
    $username = "";
    if (isset($_REQUEST['password'])) $_password = $_REQUEST['password'];
    if (isset($_REQUEST['username'])) $username = $_REQUEST['username'];
    
    if ($_password=="" || $username=="") {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }

    if(!isset($accounts[$username])) {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }
    
    if($accounts[$username] != $_password) {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }


    #Check if folder exist
    if (!file_exists("data/$username")) {
        mkdir("data/$username", 0777, false);
    }
    if (!file_exists("data/$username/pdfscorecards")) {
        mkdir("data/$username/pdfscorecards", 0777, false);
    }
    if (!file_exists("data/$username/scorecards")) {
        mkdir("data/$username/scorecards", 0777, false);
    }
?>