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
	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], "");
	}
	
	
	
	
	$html=
<<<HEREDOC
<div id="contenu_recherche_film">
	<h1>Liste des Films</h1>
	<h2>Trier par :</h2> 
	<ul class="criteres_recherche">
		<li><div onclick="afficheCategorie();" style="width:auto; cursor: pointer;">Categories</div></li>
	</ul>
HEREDOC;

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
	

	$html .="</div><br/>";

	$listeFilm = null;
	if(!isset($_POST['categorie']) && !isset($_POST['recherche'])){
	$listeFilm = getAllFilms();
	
	}else if(isset($_POST['categorie'])){
	$listeFilm = 	getFilmByCategorie($_POST['categorie']);
	}else if(isset($_POST['recherche'])){
	$listeFilmAll = getAllFilms();
	$j = 0 ;
	$listeFilm = array();
		for($i=0;$i<count($listeFilmAll) ;$i++){
	
			if (preg_match("/\b".$_POST['recherche']."\b/i", $listeFilmAll[$i]['film_titre'])){
				$listeFilm[$j] = $listeFilmAll[$i];
				$j++ ; 
			}
		}		
	}
	
	
	
	if($listeFilm != null){
		for($i = 0 ; $i < count($listeFilm) ; $i++){
			
		           $idres =        getFilmRealisateurIdById($listeFilm[$i]['film_id']);
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
				foreach ($listeNotesFilm as $note)
					$sum = $sum + $note['note_val'];
				$moyenne = sprintf('%01.1f', $sum / count($listeNotesFilm));
			}
			
			
			//////methode permettand de lister les acteurs , fonctionne même si l'id d'un acteur est egal a null
			
		             $listeActeursFilm = getListeActeurByFilmId($listeFilm[$i]['film_id']);
                        
                        $liste = "";
                        for($k = 0 ; $k < count($listeActeursFilm) ; $k ++){
                                
                                if($listeActeursFilm[$k]['listeActeur_acteur_id'] != null){
                        
                                        $liste .= getActeurPrenomById($listeActeursFilm[$k]["listeActeur_acteur_id"]).' '.getActeurNomById($listeActeursFilm[$k]["listeActeur_acteur_id"]).' - ';
                                
                                }else {
                                        $liste .= "..." ;
                                        break ;
                                }       
                                //stop la boucle si 3 acteurs sont listés
                                if( $k > 3 ){
                                        break ;
                                }               
                        }
			
			$html .= 
				'<div id="listeFilm">
					<div id="picture">
						<img  src="./images/'.$image.'.jpg"></img>
					</div> 
					<div id="content_info"> ';
			////permet de lister les informations du films , prend en compte si le film ne possède pas de réalisateur ou si realisateur id = null
		  						 $html .="<h3>".$listeFilm[$i]['film_titre']."</h3>" ;
                                                if($res == null){                                                       
                                                        $html.= '
                                                <ul>
                                                        <li><span class="bold">Date : </span>'.$listeFilm[$i]['film_date'].'</li>
                                                        <li><span class="bold">Realisateur : </span>Pas de realisateur</li>
                                                        <li><span class="bold">Acteurs : </span>'.$liste.'</li>
                                                        <li><span class="bold">Note : </span>'.$moyenne.'</li>
                                                ' ;
                                                }else{
                                                
                                                $html.= '
                                                <ul>
                                                        <li><span class="bold">Date : </span>'.$listeFilm[$i]['film_date'].'</li>
                                                        <li><span class="bold">Realisateur : </span>'.$res['realisateur_prenom'].' '.$res['realisateur_nom'].'</li>
                                                        <li><span class="bold">Acteurs : </span>'.$liste.'</li>
                                                        <li><span class="bold">Note : </span>'.$moyenne.'</li>
                                                ' ;
                                                }
                                                
							if(isset($_SESSION['user_id'])){
								$html .= '
							<li>
								<form method="post" action="./controller/film_controller.php?action=film_statistiques" name="form_stats">
									<input type="hidden" name="film_id" value="'.$listeFilm[$i]['film_id'].'" />
									<button type="submit" style="background:none; border:0; font-size: 10px; font-style:italic; padding:0; text-decoration: underline;" 
									onMouseOut="style.fontWeight=\'normal\';"  
									onMouseOver="style.fontWeight=\'bolder\';">Statistiques</button>
								</form>
							</li>';
							}
							$html .='
						</ul>
						<form method="post" action="fiche_film.php" >
							<input type="hidden" name="filmId" value="'.$listeFilm[$i]['film_id'].'" />
							<button type="submit" id="button_film_fiche" ><span>Voir la fiche</span><div class="img"></div></button>
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