<?php
    include "passwordcheck.php";
	$tabHeaderPosition = '<div class="bs-example table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>Name</th><th>Position</th><th>Catégorie</th><th>Club</th><th></th></tr></thead><tbody>';
	$tabFooter = '</tbody></table></div>';
	$password = "";
	if (isset($_POST['password'])) $password = $_POST['password'];
	if ($password=="" || $password!=$passwordcheck) {
		header('HTTP/1.0 401 Unauthorized');
		die();
	}

	// Write event name in a file
	include "saveeventname.php";
	
	$jsonData = stripslashes($_POST['data']);
	$obj = json_decode($jsonData);
	$title = $obj->{'title'};
	$file = fopen("positions.html","w");
	// header
	fwrite($file,'<h2>'.$title.'</h2>');
	fwrite($file,$tabHeaderPosition);
	$archerList = $obj->{'archerList'};
	foreach ($archerList as $archerItem) {
		$name = $archerItem->{'name'};
		$club = $archerItem->{'club'};
		$categ = $archerItem->{'categ'};
		$position = $archerItem->{'position'};
		$trispot = $archerItem->{'trispot'};
		fwrite($file, '<tr>');
		fwrite($file, '<td>'.$name.'</td>');
		fwrite($file, '<td>'.$position.'</td>');
		fwrite($file, '<td>'.$categ.'</td>');
		fwrite($file, '<td>'.$club.'</td>');
		if ($trispot) fwrite($file, '<td><img src="./images/trispot.png"></td>');
		else fwrite($file, '<td><img src="./images/singlespot.png"></td>');
		fwrite($file, '</tr>');
		
	}
	fwrite($file, $tabFooter);
	fclose($file);

	$timestampFile = fopen("timestamp.json","w");
	fwrite($timestampFile,'{"timestamp":'.time().'}');
	fclose($timestampFile);
?>