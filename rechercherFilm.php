<?php

	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';	
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
	$doc = new Document();
	if(!isset($_SESSION['level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['level']);
	}
	
	
	
	$html=
<<<HEREDOC
<div id="contenu_recherche_film">
	<h1>Liste des Films</h1>
	<h2>Trier par :</h2> 
	<ul class="criteres_recherche">
		<li><div onclick="document.getElementById('categorie_recherche').style.display = 'block';" style="width:auto; cursor: pointer;">Categories</div></li>
		<li><div onclick="document.getElementById('categorie_recherche').style.display = 'none';" style="width:auto; cursor: pointer;">Recherche Avancee</div></li>
		<li><div onclick="document.getElementById('categorie_recherche').style.display = 'none';" style="width:auto; cursor: pointer;">Note</div></li>
	</ul>
HEREDOC;

	$listeCategorie = getAllCategories();
if($listeCategorie != -1){	
	$html .= '
	<div id="categorie_recherche" style="display:none;">';
	for($i=0 ; $i< count($listeCategorie) ; $i++){
		$j = $i+1 ;
		$html .= '<form action="rechercherFilm.php" method=post>	
	 				<div onClick="document.forms['.$j.'].submit();" style="cursor: pointer;" >+'.$listeCategorie[$i]['catFilm_libelle'].'</div>
	 				<input type="hidden" value="'.$listeCategorie[$i]['catFilm_id'].'" name="categorie"/>
				  </form>';
		
	}
	
}else{
	$html.= "Il n'y a pas de catégories disponible pour le moment !" ;
}	
	
	$html .= '
	</div>';

	$html."<br/>";

	
	if(!isset($_POST['categorie'])){
	$listeFilm = getAllFilms();
	
	}else if(isset($_POST['categorie'])){
	$listeFilm = 	getFilmByCategorie($_POST['categorie']);
	}
	
	if($listeFilm != -1){
		for($i = 0 ; $i < count($listeFilm) ; $i++){
			$idres =	getFilmRealisateurIdById($listeFilm[$i]['film_id']);
			$res = getRealisateurById($idres);		
			$image = getFilmImageIdById($listeFilm[$i]['film_id']); 
			$html .= 
				'<div id="listeFilm">
					<div id="picture">
						<img  src="./images/'.$image.'.jpg"></img>
					</div> 
					<div id="content_info"> ';
						$html .=
						"<h3>".$listeFilm[$i]['film_titre']."</h3>" ;
						$html.= '
						<ul>
							<li><span class="bold">Date : </span>'.$listeFilm[$i]['film_date'].'</li>
							<li><span class="bold">Realisateur : </span>'.$res['realisateur_prenom'].' '.$res['realisateur_nom'].'</li>
							<li><span class="bold">Acteurs : </span></li>
							<li><span class="bold">Note : </span></li>
						</ul>
						<form method="post" action="fiche_film.php" >
							<input type="hidden" name="filmId" value="'.$listeFilm[$i]['film_id'].'" />
							<input type="submit" value="Voir la fiche" />
						</form>
					</div>
					<div style="clear:both;"></div>
				</div>';
		}
		echo $html.'</div>' ;		
	}else{
		echo $html."</br>"."<span class='erreur'>Il n'y a pour le moment aucun film dans notre base de donnees, veuillez nous en excuser.</span>"."</br>"."</div>";
	}
		
	
	$doc->end();

?>