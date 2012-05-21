<?php

	require_once 'persistence/user_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
	
	
	if(isset($_POST['site_lib']) && isset($_POST['film_id'])){
		
		require_once("./php4-imdbonly/trunk/imdb.class.php"); 
		require_once("./php4-imdbonly/trunk/imdbsearch.class.php");
		
		$film = new imdb($_POST['film_id']);
		
		$title = $film->title();
		$year = $film->releaseInfo();
		$rating = $film->mpaa();
		$trailer = $film->trailers();
		$genre = $film->genres();
		$realisateur = $film->director();
		$resumer = $film->storyline();
		$acteurs = $movie->cast();
		$image = $film->photo();
		
		$url = $image;
		// Le chemin de sauvegarde
		$path = './images/';
		// On recup le nom du fichier
		$name = array_pop(explode('/',$url));
		// On copie le fichier
		copy($url,$path.'/'.$_POST['film_id'].'.jpg');
		
		///////////////////////ajout du film /////////////////////////////////
		//verifie si le realisateur à déja été ajouter
		$resVal = explode( " " ,$res);
		if(!(getRealisateurIdByPrenom($resVal[0]) == -1 && getRealisateurIdByNom($resVal[1]) == -1)){
			$resId = getRealisateurIdByPrenom($resVal[0]) ;
		}else if (!(getRealisateurIdByNom($resVal[0]) == -1 && getRealisateurIdByPrenom($resVal[1]) == -1)){
			$resId = getRealisateurIdByPrenom($resVal[0]) ;
		}else{
			addRealisateur($resVal[1],$resVal[0]); //ajout du réalisateur si il est pas dans la bdd
			$resId = getRealisateurIdByPrenom($resVal[0]) ;
		}		
		
		//ajout du film
		//date = 2012-05-09 Y-M-D			
		$date =  $year[1]['year']."-".$year[1]['mon']."-".$year[1]['day'] ;
		
		addFilm($title,$date,$_POST['film_id'],$resId, null ,$resumer,null,null,null,null);
		
		$id_film=getFilmIdByTitre($title);		
		
		//ajout acteur
		for($i = 0 ; $i < count($acteurs) ; $i++){
			$actVal = explode(" ", $acteurs[$i]['name']);
			if(acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]) == -1 ){
				addActeur($actVal[1],$actVal[0]);
			}
			$actId	= acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]);
			addListeActeur($id_film,$actId);
		}		
		for($i = 0 ; $i < count($genre) ; $i++){
			addCategorieFilm($genre[$i]);
			$id_cat = getCategorieFilmIdByLib($genre[$i]);
			addListeCategorieFilm($id_film, $id_cat);
		}
		
	}
	
	
	
	
?>