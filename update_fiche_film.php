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
			
			$delete_film = "";
			if($_SESSION['user_level'] == 3){
				$delete_film = 
				"
					<form id='form_delete_film' method='post' action='./controller/film_controller.php?action=delete_film'>
						<input type='hidden' name='film_id' value='".$film['film_id']."' />
						<button type='submit'>Supprimer le film</button>
					</form>
				";
			}
		
			$resume = $film['film_resume'];
			
			$html=
"
<div id='contenu_film' class='soria'>
	<h1>".$film['film_titre']."</h1>
	<form id='informations' method='post' action='fiche_film.php'>
		<div id='jaq_infos'>
			<div class='jaquette'>
				<img src='./images/".$film['film_image_id'].".jpg'></img>
				<input type='hidden' name='MAX_FILE_SIZE' value='2097152'><input type='file' name='nom_du_fichier'>
			</div>
			<div class='informations'>
				<ul>
					<li>
						<span class='bold'>Annn&eacute;e : </span><input type='text' name='date_film' id='date_film' data-dojo-type='dijit.form.DateTextBox' required='true'  value='".$_POST['date_film']."' />
					</li>
					<li>
						<span class='bold'>R&eacute;alis&eacute; par : </span>
						<input value='".$_POST['realisateur_prenom_film']."' type='text' name='realisateur_prenom_film' id='realisateur_prenom_film' data-dojo-type='dijit.form.TextBox'
								data-dojo-props='trim:true, propercase:true' style=' width: 100px;' />
						<input value='".$_POST['realisateur_nom_film']."' type='text' name='realisateur_nom_film' id='realisateur_nom_film' data-dojo-type='dijit.form.TextBox'
								data-dojo-props='trim:true, propercase:true' style=' width: 100px;' />
					</li>
					<li>
						<span class='bold'>Acteurs : </span>".$liste."
					</li>
					<li>
						<span class='bold'>Genre(s) : </span>".$liste_cat."
					</li>
				</ul>								
			</div>
		</div>
		<div id='resume'>
			<h2>Synopsis</h2>
			<textarea name='resumer_film' id='resumer_film' data-dojo-type='dijit.form.SimpleTextarea' style='max-width: 650px; min-height: 300px;'>".$resume."</textarea>
		</div>	
		<input type='hidden' name='filmId' value='".$film['film_id']."' />
		<input type='hidden' name='validUpdate' value='1' />
		<center><button type='submit' data-dojo-type='dijit.form.Button' id='submitButton' >Confirmer</button></center>
	</form>	
	$delete_film
</div>";
			return $html;
		}
		return "
<div id='contenu_film'>
	<h1>Erreur</h1>
	<div id='contenu_erreur'>
		<img src='./images/warning.png' style='margin: auto; width:80px; height: 66px; margin-bottom: 20px;'></img></br>
		Il n'y a pas de film correspondant � votre requete.
	</div>
</div>";
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], "");
	}
	echo contenu_fiche_film();
	$doc->end();
	


?>