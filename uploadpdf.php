<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	</head>
<body>

<?php


	include 'authent.php';

	$filename="";
	if (isset($_FILES["fileToUpload"])) $filename = $_FILES["fileToUpload"]["name"];
	

	// No file, display form
	if ($filename!="") {
	
		$temp = explode(".", $_FILES["fileToUpload"]["name"]);
		$extension = end($temp);
		if (($_FILES["fileToUpload"]["type"] == "application/pdf") && 
			($_FILES["fileToUpload"]["size"] < 5000000) && 
			($extension=="pdf")) {

			if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "data/$username/pdfscorecards/scorecards.pdf")) {
				copy("data/$username/pdfscorecards/scorecards.pdf", "data/$username/pdfscorecards/".date('Ymd')."_scores.pdf");
				die("Le fichier a ete mis en ligne.<br>Vous pouvez le retrouver sur votre page de resultats.");
		
			} else {
				die("<p style='color:#F00'>Impossible de mettre en ligne ce fichier.</p>");
			}

		} else {
			die("<p style='color:#F00'>Le fichier doit etre un PDF de moins de 5Mo.</p>");
		}
	}else {
		?>
		<br>
		<div class="container">
			<img src="images/logo.png">
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
        						<input type="password" class="form-control" id="password" name="password" value="<?php echo $_REQUEST['password']; ?>">
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
