<?php


    $_password = "";
    $username = "";
    if (isset($_REQUEST['password'])) $_password = $_REQUEST['password'];
    if (isset($_REQUEST['username'])) $username = $_REQUEST['username'];
    
    if ($_password=="" || $username=="") {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }

    $_jsonStr = file_get_contents("users.json");
    $_config = json_decode($_jsonStr, true);

    if(!isset($_config['accounts'][$username])) {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }
    
    if($_config['accounts'][$username] != $_password) {
        header('HTTP/1.0 401 Unauthorized');
        die();
    }


    #Check if folder exist
    if (!file_exists("data/$username")) {
        mkdir("data/$username", 0777, false);
    }
    if (!file_exists("data/$username/scorecards")) {
        mkdir("data/$username/scorecards", 0777, false);
    }
        
    if (!file_exists("data/$username/index.php")) {
        copy("templates/index.php", "data/$username/index.php");
    }
    if (!file_exists("data/$username/getevent.php")) {
        copy("templates/getevent.php", "data/$username/getevent.php");
    }
?>