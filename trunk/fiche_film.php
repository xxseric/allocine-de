<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/realisateur_dao.php';
		
	function contenu_fiche_film()
	{
		$film = getFilmById($_GET['id']);
		if(!is_object($film))
			if($film == -1)
			return "<div id='contenu_film'>Un probleme est survenu</div>";
		$realisateur = getRealisateurById($film['film_realisateur_id']);
		$html=
"<div id='contenu_film'>
	<h1>".$film['film_titre']."</h1>
	<div id='jaq_infos'>
		<div class='jaquette'>
			<img src='./images/".$film['film_image_id'].".jpg'></img>
		</div>
		<div class='informations'>
			<ul>
				<li>
					<span class='bold'>Annnée : </span>".$film['film_date']."
				</li>
				<li>
					<span class='bold'>Réalisé par : </span> ".$realisateur[0]['realisateur_prenom']." ".$realisateur[0]['realisateur_nom']."
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
			".$film['film_resume']."
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