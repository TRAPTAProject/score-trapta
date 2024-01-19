<?php


	function db_connect(){
		if(!class_exists('SQLite3'))
			die('SQLite 3 NOT supported.');
		
		try {
			$db = new SQLite3(dirname(__FILE__)."/data/data.sqlite3.db");

			$db->query("
			CREATE TABLE IF NOT EXISTS usertable (
				username TEXT NOT NULL PRIMARY KEY,
				eventdate DATETIME NOT NULL,
				eventname TEXT NOT NULL,
				show INTEGER NOT NULL
			)
			");
		}
		catch (Exception $exception) {
			echo "Failed to connect to Sqlite: " . $exception->getMessage();
			die();
		}
		return $db;
	}
	function db_disconnect($db){
		$db->close();
	}
	
?>