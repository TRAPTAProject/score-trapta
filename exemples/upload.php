<?php
    // Import the library
    include_once dirname(__FILE__)."/../trapta-score.php";
    $traptaScore = new trapta_score\TraptaScore("example.json");

    $traptaScore->manage_authent();
?>

<html>
	<head>
        <title>Upload scores</title>
		<meta charset="utf-8">
	</head>
	<body>

    <?php
        $traptaScore->upload_score();
    ?>

	</body>
</html>