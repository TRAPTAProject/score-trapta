<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="bootstrap/bootstrap.min.css" rel="stylesheet">
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<div class="col-md-4">
  					<a href="http://www.trapta.eu"><img src="http://www.trapta.eu/res/logo256.png"></a>
  				</div>
  				<div class="col-md-8">
  					<h1 style="background-color:transparent">TRAPTA<br>Résultats en direct</h1>
  				</div>
  			</div>
		</div>
		
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="bootstrap/bootstrap.min.js"></script>

		<?php
			include 'dbconnect.php';
  			$result = mysqli_query($db,"SELECT * FROM `usertable` order by `eventdate` DESC");
			while($row = mysqli_fetch_array($result))   {
				if ($row['show']==1) {
					echo "<h3>".date("j F Y, H:i", strtotime($row['eventdate']))." :</h3>";
  					echo '<a href="'.$row['username'].'" class="btn btn-primary btn-lg btn-block">'.$row['eventname'].'</a>';
  					echo "Gestion TRAPTA : ".$row['username'];
  					echo "<br><br><br>";
  				}
  			}

			include 'dbdisconnect.php';
		?>

		

	</body>
</html>