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
		
	function contenu_user_statistiques()
	{
		if(isset($_GET['user_id'])){
			$html = "";
			$html .= "<div id='container' style='width: 450px; height: 400px; margin: 0 auto'></div>";
			return $html;
		}
		else{
			return "<div id='erreur'>Erreur</div>";
		}
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
		
		$html = "
		<div id='content_stats_film'>
			<h1>Statistiques</h1>
			<div name='note_moyenne'>
				<h3>Note moyenne : </h3> 
				<h3>Meilleure note : </h3>
				<h3>Pire note : </h3>
				<h3>Nombre de notes : </h3>
				<h3>Votes des groupes : </h3>
				<div id='container' style='width: 450px; height: 400px; margin: 0 auto'></div>
			</div>
		</div>
		";
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