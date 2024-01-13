<?php
	$tabHeaderHeats = '<div class="bs-example table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>Rang</th><th>Nom</th><th>Volée</th><th>Série 1</th><th>Série 2</th><th>Total</th><th>Cible</th><th></th><th></th></tr></thead><tbody>';
	$tabHeaderTeams = '<div class="bs-example table-responsive"><table class="table table-striped table-bordered table-hover"><thead><tr><th>Rang</th><th>Equipe</th><th>Score</th></tr></thead><tbody>';
	$tabHeaderScorecard3 = '<div class="bs-example table-responsive"><table class="table table-striped table-bordered"><thead><tr><th></th><th></th><th></th><th>Volée</th><th>Score</th></tr></thead><tbody>';
	$tabHeaderScorecard6 = '<div class="bs-example table-responsive"><table class="table table-striped table-bordered"><thead><tr><th></th><th></th><th></th><th></th><th></th><th></th><th>Volée</th><th>Score</th></tr></thead><tbody>';
	$tabFooter = '</tbody></table></div>';
	
	include 'authent.php';

	$jsonData = stripslashes($_POST['data']);
	$obj = json_decode($jsonData);

	$volleyIndex = $obj->{'volleyIndex'};
	$volleyIndex++;
	$runIndex = $obj->{'heatIndex'};
	$runIndex++;
	$arrowCount = $obj->{'arrowCount'};

	// ############################################ PROCESSING ARCHER RANKING #################################

	$file1 = fopen("data/$username/ranking.html","w");
	// header
	$categArray = $obj->{'ranking'};
	if (isset($obj->{'roundId'})) {
		$roundId = $obj->{'roundId'};
		fwrite($file1,'<h2>Départ '.$roundId.'</h2>');
	}

	foreach ($categArray as $categObj) {
		$archerArray = $categObj->{'archerList'};
		if (count($archerArray)<1) continue;
		$categTitle = $categObj->{'categName'};
		$cut = $categObj->{'cut'};
		fwrite($file1,'<h2 class="p-2 mb-2 bg-secondary text-white">'.$categTitle.'</h2><h4>Série '.$runIndex.' - Volée '.$volleyIndex.'</h4>');
		fwrite($file1, "Appuyez sur une ligne du tableau pour consulter la feuille de score de l'archer");
		fwrite($file1,$tabHeaderHeats);
		$cutIndex = 0;
		foreach ($archerArray as $archerItem) {
			$rank = $archerItem->{'rank'};
			$archer = $archerItem->{'archer'};
			$name = $archer->{'name'};
			$noc = "";
			if (isset($archer->{'club'})) $noc = $archer->{'club'};
			$id = $archer->{'id'};
			$trend = $archer->{'trend'};
			$shift = 0;
			$namenoc = $name.'<br>'.$noc;
			if (isset($archer->{'shift'})) $shift = $archer->{'shift'};
			$volleyScore = $archer->{'volleyScore'};
			if ($volleyScore>-1) $volleyScore='('.$volleyScore.')';
			else $volleyScore='(?)';
			$position = $archer->{'position'};
			$score0 = $archer->{'score0'};
			$score1 = '';
			$total = '';
			if (isset($archer->{'score1'})) $score1 = $archer->{'score1'};
			if (isset($archer->{'total'})) $total = $archer->{'total'};
			fwrite($file1, '<tr onclick=\'showScorecard("'.$namenoc.'","scorecards/scorecard'.$id.'.html")\'>');
			fwrite($file1, '<td>'.$rank.'</td>');
			fwrite($file1, '<td>'.$name.'</td>');
			fwrite($file1, '<td>'.$volleyScore.'</td>');
			fwrite($file1, '<td>'.$score0.'</td>');
			fwrite($file1, '<td>'.$score1.'</td>');
			fwrite($file1, '<td>'.$total.'</td>');
			fwrite($file1, '<td>'.$position.'</td>');
			// shift
			if ($shift==0) {
				fwrite($file1, '<td></td>');
			}
			else if ($shift<0) {
				fwrite($file1, '<td><img src="../../images/arrowdown.png">'.$shift.'</td>');
			}
			else if ($shift>0) {
				fwrite($file1, '<td><img src="../../images/arrowup.png">+'.$shift.'</td>');
			}
			// trend
			if ($trend==-2) fwrite($file1, '<td><img src="../../images/smiley-2.png"></td>');
			else if ($trend==-1) fwrite($file1, '<td><img src="../../images/smiley-1.png"></td>');
			else if ($trend==1) fwrite($file1, '<td><img src="../../images/smiley1.png"></td>');
			else if ($trend==2) fwrite($file1, '<td><img src="../../images/smiley2.png"></td>');
			else fwrite($file1, '<td></td>');
			fwrite($file1, '</tr>');
			$cutIndex++;
			if ($cut>0 && $cutIndex==$cut) {
				fwrite($file1, '<tr class="warning"><td></td><td>Limite qualification phases finales</td></tr>');
			}
		}
		fwrite($file1, $tabFooter);
	}
	fclose($file1);

	// ############################################ PROCESSING SCORECARDS #################################
	foreach ($categArray as $categObj) {
		$archerArray = $categObj->{'archerList'};
		foreach ($archerArray as $archerItem) {
			$archer = $archerItem->{'archer'};
			$id = $archer->{'id'};
			$cardArray = $archer->{'scorecard'};
			$file3 = fopen("data/$username/scorecards/scorecard".$id.".html","w");	
			$counter = 1;
			foreach ($cardArray as $card) {
					fwrite($file3, 'SÉRIE '.$counter.'<br>');
					$counter++;
					if ($arrowCount==3) fwrite($file3, $tabHeaderScorecard3);
					else if ($arrowCount==6) fwrite($file3, $tabHeaderScorecard6);
					$scoreSum = 0;
					foreach ($card as $volley) {
						$volleySum = 0;
						fwrite($file3, '<tr>');
						for ($index=0; $index<$arrowCount; $index++) {
							if ($volley[$index]>-1) {								
								if ($volley[$index]>10) {
									$volleySum += 10;
									fwrite($file3, '<td>10X</td>');
								}
								else {
									$volleySum += $volley[$index];
									fwrite($file3, '<td>'.$volley[$index].'</td>');											
								}
							}
							else {
								fwrite($file3, '<td>?</td>');	
							}
						}	
						$scoreSum += $volleySum;
						fwrite($file3, '<td>'.$volleySum.'</td>');									
						fwrite($file3, '<td>'.$scoreSum.'</td>');									
						fwrite($file3, '</tr>');
					}
					fwrite($file3, $tabFooter);
					fwrite($file3, '<br>');
			}
			fclose($file3);
				
		}
	}


	// ############################################ PROCESSING TEAM RANKING #################################
	$file2 = fopen("data/$username/teams.html","w");
	if (isset($obj->{'team'})) {				
		// header
		fwrite($file2,'<h4>SÉRIE '.$runIndex.' - VOLÉE '.$volleyIndex.'</h4>');			
		$categArray = $obj->{'team'};
		foreach ($categArray as $categName => $arrayObj) {
			fwrite($file2,'<h2>'.$categName.'</h2><h4>Série '.$runIndex.' - Volée '.$volleyIndex.'</h4>');
			fwrite($file2, "Appuyez sur une ligne du tableau pour consulter la composition de l'équipe");
			fwrite($file2,$tabHeaderTeams);
			foreach ($arrayObj as $teamItem) {
				$rank = $teamItem->{'rank'};
				$name = $teamItem->{'name'};
				$score = $teamItem->{'score'};
				$archerlist = $teamItem->{'archerList'};
				fwrite($file2, '<tr onclick=\'showTeam("'.$categName.' - '.$name.'","'.$archerlist.'")\'>');
				fwrite($file2, '<td>'.$rank.'</td>');
				fwrite($file2, '<td>'.$name.'</td>');
				fwrite($file2, '<td>'.$score.'</td>');
				fwrite($file2, '</tr>');
			}
			fwrite($file2, $tabFooter);
		}
		
	}
	fclose($file2);

	// ############################################ PROCESSING TIMESTAMP #################################
	$timestampFile = fopen("data/$username/timestamp.json","w");
	fwrite($timestampFile,'{"timestamp":'.time().'}');
	fclose($timestampFile);
	
?>