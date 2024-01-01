<?php
	$displayType = 1;
	if (isset($_GET['displayType'])) $displayType = $_GET['displayType'];
	// Read event name
	$eventname = "Tir non nommé";
	$eventnameFile = fopen("eventname.txt","r");
	if ($eventnameFile) {
		$eventname = fread($eventnameFile,50);
		fclose($eventnameFile);
	}
	
?>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="./bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="./bootstrap/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	</head>
	<body onload="checkTimestamp();setInterval('checkTimestamp()', 15000)">
		<table>
			<tr><td style='padding:5px 20px 5px 15px'><a href="https://github.com/TRAPTAProject"><img src="./images/logo.png"></a></td>
				<td width="100%">
					<a href="http://www.trapta.fr"></a>
					<p id="lastupdate"></p>
					<p id="lastsync"></p>
				</td>
			</tr>
		</table>

		<h1><?php echo $eventname; ?></h1>
		
		<ul class="nav nav-pills">
			<?php
				if ($displayType==0) echo '<li class="active"><a href="#">Positions</a></li>';
				else echo '<li><a href="index.php?displayType=0">Positions</a></li>';
					if ($displayType==1) echo '<li class="active"><a href="#">Tir individuels</a></li>';
				else echo '<li><a href="index.php?displayType=1">Tir individuels</a></li>';
				if ($displayType==3) echo '<li class="active"><a href="#">Par &eacute;quipes</a></li>';
				else echo '<li><a href="index.php?displayType=3">Par &eacute;quipes</a></li>';
				if ($displayType==2) echo '<li class="active"><a href="#">Matches</a></li>';
				else echo '<li><a href="index.php?displayType=2">Matches</a></li>';
			?>
		</ul>
		
		<div id="info"></div>
		<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="./bootstrap/bootstrap.min.js"></script>
		<script src="./bootstrap/bootstrap-dialog.min.js"></script>
		<script>
			<?php
				if ($displayType==0) echo 'datafilename = "positions.html";';
				if ($displayType==1) echo 'datafilename = "ranking.html";';
				if ($displayType==2) echo 'datafilename = "matches.html";';
				if ($displayType==3) echo 'datafilename = "teams.html";';
			?>
			mytimestamp = 0;

			// this return the date and time as a formatted string. Input value is millisec since epoch
			function formatDate(millisec) {
				var myDate = new Date(millisec);
				var day = myDate.getDate(); if (day<10) day = '0'+day;
				var month = myDate.getMonth()+1; if (month<10) month = '0'+month;
				var year = myDate.getFullYear();
				var hour = myDate.getHours(); if (hour<10) hour = '0'+hour;
				var minute = myDate.getMinutes(); if (minute<10) minute = '0'+minute;
				var second = myDate.getSeconds(); if (second<10) second = '0'+second;
				return year+'-'+month+'-'+day+'&nbsp;&nbsp;&nbsp;'+hour+':'+minute+':'+second;

			}

			// this is called every n seconds to check the timestamp on the server. 
			/// If the timestamp has changed, update content.
			function checkTimestamp() {
				
				var currentdate = new Date();
				$.getJSON("timestamp.json?"+currentdate.getTime(), function(data) {
					if (data.timestamp!=mytimestamp) {
						mytimestamp = data.timestamp;
						document.getElementById('lastupdate').innerHTML="Mise à jour: "+formatDate(mytimestamp*1000);
						updateContent();
					}
					document.getElementById('lastsync').innerHTML="Synchro: "+formatDate(currentdate.getTime());
				}
				);
			}

			// this updates the content by downloading the right fragment
			function updateContent() {
				
				var currentdate = new Date();
				$.ajax({
				  	url: datafilename+"?"+currentdate.getTime(),
  					data: {},
  					success: function(oData) {
  						document.getElementById('info').innerHTML=oData;
  					},
  					dataType: 'html'
				});
			}

			function showScorecard(name, scorecard) {		
				var currentdate = new Date();
				BootstrapDialog.show({title:name, message: $('<div></div>').load(scorecard+"?"+currentdate.getTime())});
			}

			function showTeam(name, msg) {
				BootstrapDialog.show({title:name, message:msg});
			}

		</script>
	</body>
</html>
