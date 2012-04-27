<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/acteur_dao.php';
		
	function contenu_fiche_film()
	{
		$film = getFilmById($_POST["filmId"]);
		if(count($film) == 0)
			return "Un probleme est survenu";	

		$realisateur_nom = getRealisateurNomById(getFilmRealisateurIdById($film['film_id']));
		$realisateur_prenom = getRealisateurPrenomById(getFilmRealisateurIdById($film['film_id']));
		
		$listeActeursFilm = getListeActeurByFilmId($film['film_id']);
		$liste = "";
		if(count($listeActeursFilm) >= 3){
			for($i=0; $i<3; $i++)
				$liste .= getActeurPrenomById($listeActeursFilm[$i]["listeActeur_acteur_id"]).' '.getActeurNomById($listeActeursFilm[$i]["listeActeur_acteur_id"]).' - ';
			$liste .="...";
		}else if(count($listeActeursFilm) > 0){
			foreach ($listeActeursFilm as $acteurFilm)
				$liste .= getActeurPrenomById($acteurFilm[0]["listeActeur_acteur_id"]).' '.getActeurNomById($acteurFilm[0]["listeActeur_acteur_id"]).' - ';
			$liste .="...";
		}
		
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
					<span class='bold'>AnnnÈe : </span>".$film['film_date']."
				</li>
				<li>
					<span class='bold'>RÈalisÈ par : </span>".$realisateur_prenom.' '.$realisateur_nom."
				</li>
				<li>
					<span class='bold'>Acteurs : </span>".$liste."
				</li>
				<li>
					<span class='bold'>Genre(s) : </span>Science fiction, Com√©die
				</li>
				<li>
					<span class='bold'>Nationalit√©(s) : </span>Am√©ricain
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