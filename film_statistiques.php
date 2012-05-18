<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/listeCategoriesFilm_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
	require_once 'persistence/filmFavoris_dao.php';
	require_once 'persistence/note_dao.php';
	require_once 'persistence/groupe_dao.php';
		
function sksort(&$array, $subkey = "id", $subkey2 = null ,$sort_ascending=false)
{
	if (count($array))
		$temp_array[key($array)] = array_shift($array);

	foreach($array as $key => $val){
		$offset = 0;
		$found = false;
		foreach($temp_array as $tmp_key => $tmp_val)
		{
			if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey]))
			{
				$temp_array = array_merge(
					(array)array_slice($temp_array,0,$offset), array($key => $val),
					array_slice($temp_array,$offset));
				$found = true;
			}
			elseif(!$found
				and $subkey2 and strtolower($val[$subkey]) == strtolower($tmp_val[$subkey])
				and strtolower($val[$subkey2]) > strtolower($tmp_val[$subkey2]))
			{
				$temp_array = array_merge(
					(array)array_slice($temp_array,0,$offset),
					array($key => $val), array_slice($temp_array,$offset));
				$found = true;
			}
			$offset++;
		}
		if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
	}

	if ($sort_ascending) $array = array_reverse($temp_array);

	else $array = $temp_array;
}
	
	$en_tete = "";
	
	if(isset($_GET['film_id']) && isset($_SESSION['user_id'])){
		$en_tete = "
		<script type='text/javascript' src='./js/themes/normal.js'></script>
		<script type='text/javascript'>
			function handleData(data){
				console.log(data);
				var chart = new Highcharts.Chart({
		
					'chart': {
						'renderTo': 'container',
						'type': 'column'
					},
					'title': {
						'text': 'Vos 3 meilleures notations'
					},
					'xAxis': {
						'categories': ['Men In Black I', 'Men In Black II', 'Men In Black III'],
						'title': {
							'text': 'Films'
						}
					},
					'yAxis': {
						'min': 0,
						'max': 5,
						'title': {
							'text': 'Note (/5)',
							'align': 'high'
						}
					},
					'tooltip': {
						'formatter': function() {
							return ''+this.series.name +': '+ this.y +'/5';
						}
					},
					'plotOptions': {
						'bar': {
							'dataLabels': {
								'enabled': true
							}
						}
					},
					'credits': {
						'enabled': false
					},
					'series': [{
						'name': 'Note',
						'data': [4.8, 4.9, 5]
					}]
				});
		};
		$(document).ready(function(){
			$.ajax({
				datatype: 'json',
				success: function(data){ handleData(data); },
				error: function(data){}
			});
		});
		</script>
		";
		
		$notes = getNotesByFilmId($_GET['film_id']);
		$user_note = null;
		if(count($notes) == 0){
			$aucune_notes = "Il n'y a pour le moment aucune note sur ce film";
			$html = "
			<div id='content_stats_film'>
				<h1>Statistiques</h1>
				<div id='contenu_erreur'>
					<img src='./images/warning.png' style='margin: auto; width:80px; height: 66px; margin-bottom: 20px;'></img></br>
					Il n'y a pour le moment aucune note sur ce film.
				</div>
			</div>
			";
		}
		else{
			$sum = 0;
			if(count($notes) == 1){
				$sum = $sum + $notes[0]['note_val'];
				$moyenne = sprintf('%01.1f', $sum);
			}
			else if(count($notes) > 1){
				foreach ($notes as $note)
					$sum = $sum + $note['note_val'];
				$moyenne = sprintf('%01.1f', $sum / count($notes));
			}
			$user_note = getNoteByFilmIdAndUserId($_GET['film_id'], $_SESSION['user_id']);
			$film_notes = getNotesByFilmId($_GET['film_id']);
			sksort($film_notes, "note_val");
			$html = "
			<div id='content_stats_film'>
				<h1>Statistiques</h1>
				<p>Note moyenne : <span class='value'>".$moyenne."</span></p>
				<p>Votre note : <span class='value'>".$user_note['note_val']."</span></p>";
				if(count($film_notes)> 1){
					$meilleure = $film_notes[0]['note_val'];
					$pire = $film_notes[count($film_notes)-1]['note_val'];
					$html .= "<p>Meilleure note : <span class='value'>".$meilleure."</span></p>
							<p>Pire note : <span class='value'>".$pire."</span></p>";
				}
				$html .= "<p>Les notes de groupes</p>
				<div id='container' style='width: 450px; height: 400px; margin: 0 auto'></div>
			</div>
			";
		}
		
	}
	
	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], $en_tete);
	}
	echo $html;
	$doc->end();
	
	
?>