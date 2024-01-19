<?php
	$displayType = 1;
	if (isset($_GET['displayType']))
        $displayType = $_GET['displayType'];

	$username = basename(getcwd());
	$eventname = "Event name";

	include '../../db.php';
	$db = db_connect();
		$result = $db->query("SELECT * FROM `usertable` WHERE `username`='".$username."'");
		$eventname = "Event";
		$date = "Date";
	if ($row = $result->fetchArray()) {
		$eventname = $row['eventname'];
		$date = $row['eventdate'];
	}
	db_disconnect($db)
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
	<body onload="checkTimestamp();setInterval('checkTimestamp()', 15000)">
	
		<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

		<table>
			<tbody>
				<tr>
					<td style='padding:5px 20px 5px 15px'><a href="../../"><img src="../../images/logo.png"></a></td>
					<td width="100%">
						<a href="/"></a>
						<p id="lastupdate"></p>
						<p id="lastsync"></p>
					</td>
				</tr>
			</tbody>
		</table>
		
		<h1 class="p-3 mb-2 bg-secondary text-white"><?php echo "$eventname - ".date("d M Y, H:i", strtotime($date)); ?></h1>

		
		<ul class="nav  nav-pills">
			<?php
				if ($displayType==0)
					echo '<li class="nav-item"><a class="nav-link active" href="#">Positions</a></li>';
				else
					echo '<li class="nav-item"><a class="nav-link" href="index.php?displayType=0">Positions</a></li>';
				if ($displayType==1)
					echo '<li class="nav-item"><a class="nav-link active" href="#">Tir individuels</a></li>';
				else
					echo '<li class="nav-item"><a class="nav-link" href="index.php?displayType=1">Tir individuels</a></li>';
				if ($displayType==3)
					echo '<li class="nav-item"><a class="nav-link active" href="#">Par &eacute;quipes</a></li>';
				else
					echo '<li class="nav-item"><a class="nav-link" href="index.php?displayType=3">Par &eacute;quipes</a></li>';
				if ($displayType==2)
					echo '<li class="nav-item"><a class="nav-link active" href="#">Matches</a></li>';
				else 
					echo '<li class="nav-item"><a class="nav-link" href="index.php?displayType=2">Matches</a></li>';
			?>

			
			<?php if ( file_exists(dirname(__FILE__)."/pdfscorecards/scorecards.pdf") ) {?>
			<li class="nav-item">
				<a class="nav-link" href="pdfscorecards/scorecards.pdf">
					<img src="../../images/pdf.png">&nbsp;&nbsp;Feuilles de scores individuelles finales</a>
			</li>
			<?php } ?>
		</ul>
		
		
	   		
		<div id="info"></div>


		<div id="SCORECARD-MODAL" class="modal fade" tabindex="-1" role="dialog">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">
							<div id="SCORECARD-TITLE	"></div>
						</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<div class="modal-body">
						<div id="SCORECARD-CONTENT"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
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

				$("#SCORECARD-TITLE").load(name);
				$("#SCORECARD-CONTENT").load(scorecard+"?"+currentdate.getTime());
				var myModal = new bootstrap.Modal(document.getElementById('SCORECARD-MODAL'));
				myModal.show();

			}

			function showTeam(name, msg) {
				
				$("#SCORECARD-TITLE").load(name);
				document.getElementById('SCORECARD-CONTENT').innerHTML=msg;
				var myModal = new bootstrap.Modal(document.getElementById('SCORECARD-MODAL'));
				myModal.show();
			}

		</script>

		<?php
			include '../../footer.php';
		?>
	</body>
</html>