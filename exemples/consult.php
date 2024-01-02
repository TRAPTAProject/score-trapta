<html>
	<head>
        <title>Trapta Score</title>
		<meta charset="utf-8">
	</head>
	<body>
		

    <?php
        // Import the library
        include_once dirname(__FILE__)."/../trapta-score.php";
        $traptaScore = new trapta_score\TraptaScore("example.json");
    ?>
    

    <?php
        $traptaScore->print_scores();
    ?>
		

	</body>
</html>