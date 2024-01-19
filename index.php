<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
	<body>
		<div class="jumbotron">
			<div class="container">
				<div class="display-4">
					<h1 >
						<a style="margin-right: 20px" href="/">
						<img src="images/logo.png" width="70" height="70"></a>TRAPTA
					</h1>
				</div>
				<div class="display-4">
					<h2>Résultats en direct</h2>
				</div>
			</div>
		</div>
		
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<div class="container">
		<?php
			include 'db.php';
			$db = db_connect();
  			$result = $db->query("SELECT * FROM `usertable` order by `eventdate` DESC");
			while($row = $result->fetchArray())   {
				if ($row['show']==1) {
					echo "<h3 >".date("d M Y, H:i", strtotime($row['eventdate']))." :</h3>";
  					echo '<a href="user.php?username='.$row['username'].'" class="btn btn-secondary btn-lg btn-block">'.$row['eventname'].'</a>';
  					echo "Gestion TRAPTA : ".$row['username'];
  					echo "<br><br><br>";
  				}
  			}

			db_disconnect($db)
		?>
		</div>

		<?php
		include 'footer.php';
		?>

		

	</body>
</html>