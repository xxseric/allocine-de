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
	require_once 'persistence/user_dao.php';
		
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
				
		$notes = getNotesByFilmId($_GET['film_id']);
		$user_note = null;
		
		$test = getNoteByFilmIdAndUserId($_GET['film_id'], $_SESSION['user_id']);
				
		/* S'il n'y a pas de notes sur ce film */
		if($test == null){
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
			$film = getFilmById($_GET['film_id']);
			$user = getUserById($_SESSION['user_id']);
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
				<h2><a href='fiche_film.php?filmId=".$_GET['film_id']."'>-- ".$film['film_titre']." --</a></h2>
				<p>Note moyenne : <span class='value'>".$moyenne."</span></p>
				<p>Votre note : <span class='value'>".$user_note['note_val']."</span></p>";
				if(count($film_notes)> 1){
					$meilleure = $film_notes[0]['note_val'];
					$pire = $film_notes[count($film_notes)-1]['note_val'];
					$html .= "<p>Meilleure note : <span class='value'>".$meilleure."</span></p>
							<p>Pire note : <span class='value'>".$pire."</span></p>";
				}
				$html .= "<div id='container' style='width: 450px; height: 400px; margin: 0 auto'></div>
			</div>
			";
			if($user['user_groupe_id'] != null){
				$groupe = getGroupeById($user['user_groupe_id']);
				$liste_users_groupe = getUsersByGroupeId($user['user_groupe_id']);
				$sum_g = 0;
				$moyenne_g = 0;
				if(count($liste_users_groupe) == 1){
					$note_g = getNoteByFilmIdAndUserId($_GET['film_id'], $liste_users_groupe[0]['user_id']);
					$moyenne_g = sprintf('%01.1f', $note_g[0]['note_val']);
				}else if(count($liste_users_groupe) > 1){
					$i = 0;
					foreach ($liste_users_groupe as $user_g){
						if(($note_g = getNoteByFilmIdAndUserId($_GET['film_id'], $user_g['user_id'])) != null){
							$sum_g = $sum_g + $note_g['note_val'];
							$i++;
						}
					}
					$moyenne_g = sprintf('%01.1f', $sum_g / $i);
				}
			}
			else{
				$groupe = " ";
				$moyenne_g = 0;
			}
			
				
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
							'text': '".$film['film_titre']."'
						},
						'xAxis': {
							'categories': ['".$user['user_prenom']." ".$user['user_nom']."', 'Moyenne', '".$groupe['groupe_lib']."']
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
							'data': [".$user_note['note_val'].", ".$moyenne.", ".$moyenne_g."]
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
			</script>";
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