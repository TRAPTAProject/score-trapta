<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="http://score.trapta.eu/bootstrap/bootstrap.min.css" rel="stylesheet">
		<link href="http://score.trapta.eu/bootstrap/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
	</head>
<body>

<?php

	include 'dbconnect.php';
	$username = "";
	$password = "";
	if (isset($_GET["username"])) $username = htmlspecialchars($_GET["username"], ENT_QUOTES);
	if (isset($_GET["password"])) $password = htmlspecialchars($_GET["password"], ENT_QUOTES);
	if (isset($_POST["username"])) $username = htmlspecialchars($_POST["username"], ENT_QUOTES);
	if (isset($_POST["password"])) $password = htmlspecialchars($_POST["password"], ENT_QUOTES);
	$passwordError = false;
	$usernameError = false;
	$filename="";
	if (isset($_FILES["fileToUpload"])) $filename = $_FILES["fileToUpload"]["name"];
	

	// No file, display form
	if ($filename!="") {
	
  		$result = mysqli_query($db,"SELECT * FROM `usertable` WHERE `username`='".$username."'");
		if ($row = mysqli_fetch_array($result)) {
			if ($row['password']==$password) {
				$temp = explode(".", $_FILES["fileToUpload"]["name"]);
				$extension = end($temp);
				if (($_FILES["fileToUpload"]["type"] == "application/pdf") && 
					($_FILES["fileToUpload"]["size"] < 5000000) && 
					($extension=="pdf")) {

  					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $username."/pdfscorecards/scorecards.pdf")) {
        				die("Le fichier a ete mis en ligne.<br>Vous pouvez le retrouver sur votre page de resultats.");
        		
    				} else {
        				die("<p style='color:#F00'>Impossible de mettre en ligne ce fichier.</p>");
    				}

				} else {
					die("<p style='color:#F00'>Le fichier doit etre un PDF de moins de 5Mo.</p>");
				}

			} else {
				die("Accès non autorisé.");
			}
		}
		else {
			die("Accès non autorisé.");
		}

	}
	else {
		?>
		<br>
		<div class="container">
			<img src="http://score.trapta.eu/images/logo.png">
  			<div class="bs-docs-section">
  				<div class="row">
          			<div class="col-lg-12">
            			<div class="page-header">
              				<h1>Poster les feuilles de scores</h1>
            			</div>
          			</div>
        		</div>



  				<form class="form-horizontal" action="uploadpdf.php" method="post" enctype="multipart/form-data">
  					<fieldset>
    					<legend>Entrez vos codes et le fichier PDF généré par TRAPTA</legend>
    					<div class="form-group">
      						<label for="username" class="col-lg-2 control-label">Identifiant</label>
      						<div class="col-lg-8">
        						<input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>">
      						</div>
      					</div>
      					<div class="form-group">
      						<label for="password" class="col-lg-2 control-label">Mot de passe</label>
      						<div class="col-lg-8">
        						<input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
        					</div>
        				</div>
        				<div class="form-group">
        					<label for="fileToUpload" class="col-lg-2 control-label">Fichier PDF</label>
      						<div class="col-lg-8">
        						<input type="file" class="btn btn-default" id="fileToUpload" name="fileToUpload" accept="application/pdf">
        					</div>
        				</div>
        				<div class="form-group">
      						<div class="col-lg-10 col-lg-offset-2">
        			        	<button type="submit" class="btn btn-primary">Mettre en ligne</button>
      						</div>
    					</div>
    				</fieldset>
				</form>

			</div>
		</div>
		
		<?php
	}
	?>




  					
  			
  		</div>

</body>
</html> 