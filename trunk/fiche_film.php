<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
		
	function contenu_fiche_film()
	{
		$film = getFilmById($_POST['film_id']);
		if($film == -1)
			return "Un probleme est survenu";
		
		$html=
"<div id='contenu_film'>
	<h1>".$film['film_titre']."</h1>
	<div id='jaq_infos'>
		<div class='jaquette'>
			<img src='./images/mibI.jpg'></img>
		</div>
		<div class='informations'>
			<ul>
				<li>
					<span class='bold'>Annnée : </span>1997
				</li>
				<li>
					<span class='bold'>Réalisé par : </span>Barry Sonnenfeld
				</li>
				<li>
					<span class='bold'>Acteurs : </span>Will Smith, Tommy Lee Jones, Vincent D'Onofrio
				</li>
				<li>
					<span class='bold'>Genre(s) : </span>Science fiction, Comédie
				</li>
				<li>
					<span class='bold'>Nationalité(s) : </span>Américain
				</li>
			</ul>								
		</div>
	</div>
	<div id='resume'>
		<h2>Synopsis</h2>
		<p>
			Chargés de protéger la Terre de toute infraction extraterrestre et de réguler l'immigration intergalactique sur notre planète, 
			les Men in black ou MIB opèrent dans le plus grand secret. Vêtus de costumes sombres et équipés des toutes dernières technologies, 
			ils passent inaperçus aux yeux des humains dont ils effacent régulièrement la mémoire récente : la présence d'aliens sur notre sol 
			doit rester secrète. Récemment séparé de son vieux partenaire, retourné à la vie civile sans aucun souvenir de sa vie d'homme en noir, 
			K, le plus expérimenté des agents du MIB décide de former J, un jeune policier. Ensemble, ils vont afronter une nouvelle menace : 
			Edgar le cafard...
		</p>
	</div>
</div>";
		return $html;
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['level']);
	}
	echo contenu_fiche_film();
	$doc->end();

?>