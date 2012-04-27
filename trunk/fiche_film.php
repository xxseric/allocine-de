<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/listeCategoriesFilm_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
		
	function contenu_fiche_film()
	{
		if(isset($_POST["filmId"])){
			$film = getFilmById($_POST["filmId"]);
			if(count($film) == 0)
				return "Un probleme est survenu";	

			$realisateur_nom = getRealisateurNomById(getFilmRealisateurIdById($film['film_id']));
			$realisateur_prenom = getRealisateurPrenomById(getFilmRealisateurIdById($film['film_id']));
		
			$listeActeursFilm = getListeActeurByFilmId($film['film_id']);
			$liste = "";
			if(count($listeActeursFilm) > 3){
				for($i=0; $i<3; $i++)
					$liste .= getActeurPrenomById($listeActeursFilm[$i]["listeActeur_acteur_id"]).' '.getActeurNomById($listeActeursFilm[$i]["listeActeur_acteur_id"]).' - ';
				$liste .="...";
			}else if(count($listeActeursFilm) > 1){
				foreach ($listeActeursFilm as $acteurFilm)
					$liste .= getActeurPrenomById($acteurFilm["listeActeur_acteur_id"]).' '.getActeurNomById($acteurFilm["listeActeur_acteur_id"]).' - ';
				$liste .="...";
			}else if((int)$listeActeursFilm != -1){
				$liste .= getActeurPrenomById($listeActeursFilm[0]["listeActeur_acteur_id"]).' '.getActeurNomById($listeActeursFilm[0]["listeActeur_acteur_id"]);
			}
		
			$listeCategories = getListeCategorieFilmByFilmId($film['film_id']);
			$liste_cat = "";		
			if(count($listeCategories) > 3){
				for($i=0; $i<3; $i++)
					$liste_cat .= getCategorieFilmLibById($listeCategories[$i]['listeCategoriesFilms_categorie_film']).'  ';
				$liste_cat .= "...";
			}else if(count($listeCategories) > 1){
				foreach ($listeCategories as $categorie)
					$liste_cat .= getCategorieFilmLibById($categorie['listeCategoriesFilms_categorie_film']).'  ';
			}else if(count($listeCategories) == 1){
				$liste_cat .= getCategorieFilmLibById($listeCategories[0]["listeCategoriesFilms_categorie_film"]).' ';
			}		
		
			$resume = "Il n'y a pour le moment aucun resume de ce film.";
			if($film['film_resume'] != null)
				$resume = $film['film_resume'];
		
			@require_once 'rating_functions.php';
			
			$inputs = "";
			$options = get_options();
			foreach($options as $id => $rb){
				$inputs .= "<input type='radio' name='rate' value='".$id."' title='".$rb['title']."' /></br>";
			}
			$inputs .= "<input type='hidden' name='film_id' value='".$film['film_id']."' /></ br>
						<input type='submit' value='Rate it' />";
			
			$html=
"
<script type='text/javascript'>
	$(function(){
		$('#rat').children().not(':radio').hide();
		$('#rat').stars({
			// starWidth: 28,
			cancelShow: false,
			callback: function(ui, type, value)
			{
				$('#rat').hide();
				$('#loader').show();
				$.post('rating_functions.php', {rate: value , film_id: value}, function()
				{
					$('#loader').hide();
					$('#rat').show();
				}, 'json');
			}
		});
	});
</script>
<div id='contenu_film'>
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
					<span class='bold'>Réalisé par : </span>".$realisateur_prenom.' '.$realisateur_nom."
				</li>
				<li>
					<span class='bold'>Acteurs : </span>".$liste."
				</li>
				<li>
					<span class='bold'>Genre(s) : </span>".$liste_cat."
				</li>
				<li>
					<span class='bold'>NationalitÃ©(s) : </span>AmÃ©ricain
				</li>
				<li class='rating'>
					<form id='rat' action='' method='post'>".$inputs." 
					</form>
					<div id='loader'><div style='padding-top: 5px;'>please wait...</div></div>
				</li>
			</ul>								
		</div>
	</div>
	<div id='resume'>
		<h2>Synopsis</h2>
		<p>
			".$resume."
		</p>
	</div>
</div>";
			return $html;
		}
		return "
<div id='contenu_film'>
	<h1>Erreur</h1>
	<div id='contenu_erreur'>
		<img src='./images/warning.png' style='margin: auto; width:80px; height: 66px; margin-bottom: 20px;'></img></br>
		Il n'y a pas de film correspondant à votre requete.
	</div>
</div>";
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['user_level']);
	}
	echo contenu_fiche_film();
	$doc->end();

?>