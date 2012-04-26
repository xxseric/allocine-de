<?php

	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once './orm/film_dao.php';	
	require_once './orm/realisateur_dao.php';
	
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
		<li><div onclick="document.getElementById('categorie_recherche').style.display = 'block';" style="width:auto; cursor: pointer;">Recherche Avancee</div></li>
		<li><div onclick="document.getElementById('categorie_recherche').style.display = 'block';" style="width:auto; cursor: pointer;">Note</div></li>
	</ul>
	<div id="categorie_recherche" style="display:none;">
		<a>-Action </a><br>
		<a>-Dramatique </a><br>
		<a>-Comédie </a><br>
		<a>-Aventure </a><br>
		<a>-Science-Fiction </a><br>
	</div>
HEREDOC;
	$html."<br/>";

	$listeFilm = getAllFilms();
	
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
					<div id="content_info"> 
						<table border="0"> ';
							$html .=
							"<h3>".$listeFilm[$i]['film_titre']."</h3>" ;
							$html.= 
							'<tr>
								<td>Date :</td>
								<td>'.$listeFilm[$i]['film_date'].'</td> 
							</tr>
							<tr>
								<td>réalisateur :</td><td>'
								.$res[0]['realisateur_prenom'].$res[0]['realisateur_nom'].'</td> 
							</tr>
							<tr>
								<td>Acteurs principaux:</td><td></td></tr> 
							<tr>
								<td>Notes : </td><td> </td>
							</tr>
						</table>
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