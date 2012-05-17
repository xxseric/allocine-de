<?php

	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';	
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
	require_once 'persistence/note_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/listeCategoriesFilm_dao.php';
	require_once 'persistence/filmFavoris_dao.php';
	require_once 'persistence/user_dao.php';
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['user_level']);
	}
	
	
	
	
	$html=
<<<HEREDOC
<div id="contenu_recherche_film">
	<h1>Liste des Films</h1>
	
HEREDOC;

	
	
	if(isset($_POST['favoris_user_id'])){
		$user = getUserById($_POST['favoris_user_id']);		
		$html .=	'<h2>Liste des films favoris de l\'utilisateur '.$user['user_nom']." ".$user['user_prenom'].'</h2>';
	}else{
		$html .= '<h2>Trier par :</h2> 
			<ul class="criteres_recherche">
		<li><div onclick="afficheCategorie();" style="width:auto; cursor: pointer;">Categories</div></li>
	</ul>';
	$listeCategorie = getAllCategories();
if($listeCategorie != null){	
	$html .= '
	<div id="categorie_recherche" style="display:none;">';
	for($i=0 ; $i< count($listeCategorie) ; $i++){
		$j = $i+1 ;
		$html .= '<form action="rechercherFilm.php" method=post>	
	 				<div onClick="document.forms['.$j.'].submit();" style="cursor: pointer;" >+'.$listeCategorie[$i]['catFilm_libelle'].'</div>
	 				<input type="hidden" value="'.$listeCategorie[$i]['catFilm_id'].'" name="categorie"/>
				  </form>';	
		}
	}

	
$html.="</div><br/>";
}
	$listeFilm = null;

	
	 if(isset($_POST['categorie'])){ //liste des films trier par categorie
	$listeFilm = 	getFilmByCategorie($_POST['categorie']);
	}else if(isset($_POST['recherche'])){ //liste des films par une recherche
	$listeFilmAll = getAllFilms();
	$j = 0 ;
	$listeFilm = array();
		for($i=0;$i<count($listeFilmAll) ;$i++){
	
			if (preg_match("/\b".$_POST['recherche']."\b/i", $listeFilmAll[$i]['film_titre'])){
				$listeFilm[$j] = $listeFilmAll[$i];
				$j++ ; 
			}
		}		
	}else if(isset($_POST['favoris_user_id'])){ //film favori d'un utilisateur
		$listeFilm = array();
		$listeFilmAll = getFilmFavorisByUserId($_POST['favoris_user_id']);	
		if(is_object($listeFilmAll)){
			 	$film = getFilmById($listeFilmAll['film_id']);
				$listeFilm[0] = $film ;
		}else{
		
		 	for($i = 0 ; $i < count($listeFilmAll) ; $i++){
			 	$film = getFilmById($listeFilmAll['film_id']);
			 	$listeFilm[$i] = $film ; 	
		 	}
		}
	}else { //liste de tous les films
		
		$listeFilm = getAllFilms();
		
	}
	
	
	$html .= '<div id="listeFilm">' ;
	if($listeFilm != null){
		for($i = 0 ; $i < count($listeFilm) ; $i++){
			$idres =	getFilmRealisateurIdById($listeFilm[$i]['film_id']);
				if($idres != null){
					$res = getRealisateurById($idres);	
				}else {
					$res = null ;
				}
				
			$image = getFilmImageIdById($listeFilm[$i]['film_id']); 
			$listeNotesFilm = getNotesByFilmId($listeFilm[$i]['film_id']);
			$sum = 0;
			$moyenne = 0;
			if($listeNotesFilm == null){
				$moyenne = "Il n'y a pour le moment aucune note d'attribu&eacute;e";
			}else if(count($listeNotesFilm) == 1){
				$sum = $sum + $listeNotesFilm[0]['note_val'];
				$moyenne = sprintf('%01.1f', $sum);
			}
			
			else if(count($listeNotesFilm) > 1){
				foreach ($listeNotesFilm as $note){
					$sum = $sum + $note['note_val'];
				}					
				$moyenne = sprintf('%01.1f', $sum / count($listeNotesFilm));
			}
			
			$listeActeursFilm = getListeActeurByFilmId($listeFilm[$i]['film_id']);
			
			$liste = "";
			for($k = 0 ; $k < count($listeActeursFilm) ; $k ++){
				
				if($listeActeursFilm[$k]['listeActeur_acteur_id'] != null){
			
					$liste .= getActeurPrenomById($listeActeursFilm[$k]["listeActeur_acteur_id"]).' '.getActeurNomById($listeActeursFilm[$k]["listeActeur_acteur_id"]).' - ';
				
				}else {
					$liste .= "..." ;
					break ;
				}	
				
				if( $k > 3 ){
					break ;
				}		
			}
			
			$html .= 
				'
					<div id="picture">
						<img  src="./images/'.$image.'.jpg"></img>
					</div> 
					<div id="content_info"> ';
						$html .=
						"<h3>".$listeFilm[$i]['film_titre']."</h3>" ;
						if($res == null){							
							$html.= '
						<ul>
							<li><span class="bold">Date : </span>'.$listeFilm[$i]['film_date'].'</li>
							<li><span class="bold">Realisateur : </span>Pas de realisateur</li>
							<li><span class="bold">Acteurs : </span>'.$liste.'</li>
							<li><span class="bold">Note : </span>'.$moyenne.'</li>
						</ul>' ;
						}else{
						
						$html.= '
						<ul>
							<li><span class="bold">Date : </span>'.$listeFilm[$i]['film_date'].'</li>
							<li><span class="bold">Realisateur : </span>'.$res['realisateur_prenom'].' '.$res['realisateur_nom'].'</li>
							<li><span class="bold">Acteurs : </span>'.$liste.'</li>
							<li><span class="bold">Note : </span>'.$moyenne.'</li>
						</ul>' ;
						}
					$html.= '	<form method="post" action="fiche_film.php" >
							<input type="hidden" name="filmId" value="'.$listeFilm[$i]['film_id'].'" />
							<button type="submit" id="button_film_fiche" ><span>Voir la fiche</span><img src="./images/fleche.png"></img></button>
						</form>
					</div>
					<div style="clear:both;"></div>
				';
						
		}
		echo $html.'</div></div>' ;		
	}else{
		echo $html."</br>"."<span class='erreur'>Il n'y a pour le moment aucun film dans notre base de donnees, veuillez nous en excuser.</span>"."</br>"."</div>";
	}
		
	
	$doc->end();

?>