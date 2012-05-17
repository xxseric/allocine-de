<?php

	
	function processFicheFilm()
	{
		return "update_fiche_film.php";
	}
	
	function processAjoutFilmById()
	{
		require_once (dirname(__FILE__) . '/../persistence/user_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/realisateur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/acteur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/film_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/listeActeur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/categorieFilm_dao.php');
		
		
		if(isset($_POST['site_lib']) && isset($_POST['film_id'])){
		
			require_once( dirname(__FILE__) . "/../php4-imdbonly/trunk/imdb.class.php");
			require_once( dirname(__FILE__) . "/../php4-imdbonly/trunk/imdbsearch.class.php");
		
			$film = new imdb($_POST['film_id']);
		
			$title = $film->title();
			$year = $film->releaseInfo();
			$rating = $film->mpaa();
			$trailer = $film->trailers();
			$genre = $film->genres();
			$realisateur = $film->director();
			$resumer = $film->storyline();
			$acteurs = $film->cast();
			$image = $film->photo();
		
			$url = $image;
			// Le chemin de sauvegarde
			$path = dirname(__FILE__) .'/../images';
			// On recup le nom du fichier
			$name = array_pop(explode('/',$url));
			// On copie le fichier
			copy($url,$path.'/'.$_POST['film_id'].'.jpg');
		
			///////////////////////ajout du film /////////////////////////////////
			//verifie si le realisateur � d�ja �t� ajouter
			$resVal = explode( " " ,$realisateur[0]['name']);
			if(!(getRealisateurIdByPrenom($resVal[0]) == -1 && getRealisateurIdByNom($resVal[1]) == -1)){
				$resId = getRealisateurIdByPrenom($resVal[0]) ;
			}else if (!(getRealisateurIdByNom($resVal[0]) == -1 && getRealisateurIdByPrenom($resVal[1]) == -1)){
				$resId = getRealisateurIdByPrenom($resVal[0]) ;
			}else{
				addRealisateur($resVal[1],$resVal[0]); //ajout du r�alisateur si il est pas dans la bdd
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
		return "fiche_film.php";
	}

?>
