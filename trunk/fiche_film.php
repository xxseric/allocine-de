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
			$rate = null;
			
			$update_fiche_film = "";
			
			if(isset($_SESSION['user_level'])){
				$options = get_options();
				foreach($options as $id => $rb){
					$inputs .= "<input type='radio' name='rate' value='".$id."' title='".$rb['title']."' /></br>";
				}
				$inputs .= "<input type='hidden' name='film_id' id='film_id' value='".$film['film_id']."' /></ br>
						<input type='submit' value='Rate it' />";				
				$rate = "<li class='rating'>
							<form id='rat' action='' method='post'>".$inputs." 
							</form>
							<div id='loader'><div style='padding-top: 5px;'>please wait...</div></div>
						</li>";	
				if($_SESSION['user_level'] > 1){
					$update_fiche_film = "
						<form method='post' action='update_fiche_film.php'>
							<input type='hidden' name='filmId' value='".$film['film_id']."' /></br>
							<input type='hidden' name='date_film' value='".$film['film_date']."' />
							<input type='hidden' name='realisateur_nom_film' value='".$realisateur_nom."' />
							<input type='hidden' name='realisateur_prenom_film' value='".$realisateur_prenom."' />
							<button type='submit' id='button_update_fiche_film' ><span>Modifier</span><img src='./images/fleche.png'></img></button>
						</form>
					";	
				}		
			}	
			
			$favoris = "";
			if(isset($_SESSION['user_level'])){
				$filmFavoris = getFilmFavorisByFilmIdAndUserId($film['film_id'], $_SESSION['user_id']);
				if( count($filmFavoris) > 0 ){
					$favoris .=    "<form id='ajout_favoris' method='post' action='./controller/filmFavoris_controller.php?action=enlever_film_favoris' >
									<input type='hidden' name='film_favoris_id' value='".$filmFavoris['film_favoris_id']."' />
									<button type='submit'><img src='./images/delete.png'></img></button>
									</form>";
				}else{
					$favoris .=    "<form id='ajout_favoris' method='post' action='./controller/filmFavoris_controller.php?action=ajouter_film_favoris' >
									<input type='hidden' name='film_id' value='".$film['film_id']."' />
									<input type='hidden' name='user_id' value='".$_SESSION['user_id']."' />
									<button type='submit'><img src='./images/add.png' value='ajouter aux favoris'></img></button>
									</form>";
				}				
			}
			
			$html=
"
<script type='text/javascript'>
	$(function(){
		$('#rat').children().not(':radio').hide();
		$('#rat').stars({
			// starWidth: 28,
    		oneVoteOnly: true,
			cancelShow: false,
			callback: function(ui, type, value)
			{
				$('#rat').hide();
				$('#loader').show();
				$.post('rating_functions.php', {rate: value , film_id: document.getElementById('film_id').value}, function()
				{
					$('#loader').hide();
					$('#rat').show();
				}, 'json');
			}
		});
	});
</script>
<div id='contenu_film'>
	".$favoris."
	<h1>".$film['film_titre']."</h1>
	<div id='jaq_infos'>
		<div class='jaquette'>
			<img src='./images/".$film['film_image_id'].".jpg'></img>
		</div>
		<div class='informations'>
			<ul>
				<li>
					<span class='bold'>Annn&eacute;e : </span>".$film['film_date']."
				</li>
				<li>
					<span class='bold'>R&eacute;alis&eacute; par : </span>".$realisateur_prenom.' '.$realisateur_nom."
				</li>
				<li>
					<span class='bold'>Acteurs : </span>".$liste."
				</li>
				<li>
					<span class='bold'>Genre(s) : </span>".$liste_cat."
				</li>".$rate."
			</ul>								
		</div>
	</div>
	<div id='resume'>
		<h2>Synopsis</h2>
		<p>
			".$resume."
		</p>
	</div>".$update_fiche_film."
</div>";
			return $html;
		}
		return "
<div id='contenu_film'>
	<h1>Erreur</h1>
	<div id='contenu_erreur'>
		<img src='./images/warning.png' style='margin: auto; width:80px; height: 66px; margin-bottom: 20px;'></img></br>
		Il n'y a pas de film correspondant &agrave; votre requete.
	</div>
</div>";
	}	
	
	
	if(isset($_POST['validUpdate'])){
	
	
		if(isset($_POST['date_film'])){
			setFilmDateById($_POST['filmId'], $_POST['date_film']);
		}
	
		if(isset($_POST['realisateur_prenom_film']) && isset($_POST['realisateur_nom_film'])){
			if(getRealisateurIdByNomAndPrenom($_POST['realisateur_nom_film'], $_POST['realisateur_prenom_film']) == -1)
				addRealisateur($_POST['realisateur_nom_film'], $_POST['realisateur_prenom_film']);
			$realisateur_id = getRealisateurIdByNomAndPrenom($_POST['realisateur_nom_film'], $_POST['realisateur_prenom_film']);
			setFilmRealisateurIdById($_POST['filmId'], $realisateur_id);
		}
	
		/*if(isset($_POST['acteur_film'])){
		 $actVal = explode( " " , $_POST['acteur_film']);
	
		if( getIdbyNomEtPrenom($actVal[1],$actVal[0]) == -1 ){
		addActeur($actVal[1],$actVal[0]);
		}
		$actId	= getIdbyNomEtPrenom($actVal[1],$actVal[0]);
		}
			
	
		$listeActeur = getActeurById($actId);*/
			
		$resumer = "";
		if(isset($_POST['resumer_film'])){
			$resumer = $_POST['resumer_film'] ;
			setFilmResumeById($_POST['filmId'], $resumer);
		}
			
		/*if ($_FILES["nom_du_fichier"]["error"] > 0)
		{
			echo "Error: " . $_FILES["nom_du_fichier"]["error"] . "<br />";
		}
		else
		{
			$chemin_destination = './images/';
			move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
			$imgId	= explode(".", $_FILES['nom_du_fichier']['name'] );
			setFilmImageIdById($_POST['filmId'], $imgId[0]);
		}
			
			
		$listeCat = getAllCategories();
		 $listeCategories = array();
		$j = 0 ;
		foreach($listeCat as $categorie){
		if(isset($_POST['categorie'.$categorie['catFilm_id']])){
		$listeCategories[$j] = $categorie['catFilm_id'] ;
		$j ++ ;
		echo "ok" ;
		}
		}
			
	
		if ((isset($_FILES['nom_du_fichier']['fichier'])&&($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK))) {
			$chemin_destination = './images/';
			move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
		}*/
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