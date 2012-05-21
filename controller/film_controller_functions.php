<?php

	require_once (dirname(__FILE__) . '/../persistence/user_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/realisateur_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/acteur_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/film_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/listeActeur_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/categorieFilm_dao.php');
	require_once (dirname(__FILE__) . '/../persistence/groupe_dao.php');
	
	function processFicheFilm()
	{
		return "update_fiche_film.php";
	}
	
	function processAjoutFilmBrut()
	{	
		if(isset($_POST['film_titre']) && isset($_POST['date_film'])){
			if(isset($_POST['realisateur_film'])){
				$resVal = explode( " " , $_POST['realisateur_film']);
				if(!(getRealisateurIdByPrenom($resVal[0]) == null && getRealisateurIdByNom($resVal[1]) == null)){
						
					$resId = getRealisateurIdByPrenom($resVal[0]) ;
				}else if (!(getRealisateurIdByNom($resVal[0]) == null && getRealisateurIdByPrenom($resVal[1]) == null)){
						
					$resId = getRealisateurIdByPrenom($resVal[0]) ;
				}else{
						
					addRealisateur($resVal[1],$resVal[0]);
					$resId = getRealisateurIdByPrenom($resVal[0]) ;
				}
					
			}				
				
			$resumer = "";
			if(isset($_POST['resumer_film'])){
				$resumer = $_POST['resumer_film'] ;
			}
				
			if ($_FILES["nom_du_fichier"]["error"] > 0)
			{
				echo "Error: " . $_FILES["nom_du_fichier"]["error"] . "<br />";
			}
			else
			{
				$chemin_destination = dirname(__FILE__) .'/../images/';
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
			}
				
			$date = explode( "/" , $_POST['date_film']);
			$imgId = explode(".", $_FILES['nom_du_fichier']['name'] );
				
				
			$listeCat = getAllCategories();
			if($listeCat != null){
				$listeCategories = array();
				$j = 0 ;
				foreach($listeCat as $categorie){
					if(isset($_POST['categorie'.$categorie['catFilm_id']])){
						$listeCategories[$j] = $categorie['catFilm_id'] ;
						$j ++ ;
					}
				}
				for($i = 0 ; $i < count($listeCategories) ; $i++ ) {
					addListeCategorieFilm($id_film, $listeCategories[$i]);
				}
			}
				
		
			if ((isset($_FILES['nom_du_fichier']['fichier'])&&($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK))) {
				$chemin_destination = dirname(__FILE__) .'/../images/';
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);
			}
		
				
			addFilm($_POST['film_titre'],$date[0],$imgId[0],$resId, null ,$resumer,null,null,null,null);
		
			$id_film=getFilmIdByTitre($_POST['film_titre']);			
			
			if(isset($_POST['acteur_film'])){
				$actVal = explode(" ",$_POST['acteur_film']);
				if(acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]) == null ){
					addActeur($actVal[1],$actVal[0]);
				}
				$act	= getActeurByNomAndPrenom($actVal[1], $actVal[0]); 
				addListeActeur($id_film,$act['acteur_id']);
			}		
		}
		return "rechercherFilm.php";
	}
	
	function processAjoutFilmById()
	{
		require_once (dirname(__FILE__) . '/../persistence/user_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/realisateur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/acteur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/film_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/listeActeur_dao.php');
		require_once (dirname(__FILE__) . '/../persistence/categorieFilm_dao.php');
		$ajoutRea = true ; 
		$ajoutActeur = true ; 
		
		if(isset($_POST['site_lib']) && $_POST['site_lib'] == 'imdb'  && isset($_POST['film_id'])){
		
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
			//verifie si le realisateur à déja été ajouter
			try{
					$resVal = explode( " " ,$realisateur[0]['name']);
					if(!(getRealisateurIdByPrenom($resVal[0]) == null && getRealisateurIdByNom($resVal[1]) == null)){
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}else if (!(getRealisateurIdByNom($resVal[0]) == null && getRealisateurIdByPrenom($resVal[1]) == null)){
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}else{
						addRealisateur($resVal[1],$resVal[0]); //ajout du réalisateur si il est pas dans la bdd
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}
			}catch(Exception $e) {
				echo "probleme détecter lors de l'ajout du realisateur " ;
				$resId = null ;
			}
			//ajout du film
			//date = 2012-05-09 Y-M-D
			$date =  $year[1]['year']."-".$year[1]['mon']."-".$year[1]['day'] ;
		
			addFilm($title,$date,$_POST['film_id'],$resId, null ,$resumer,null,null,null,null);
		
			$id_film=getFilmIdByTitre($title);
		
			//ajout acteur
	
					for($i = 0 ; $i < count($acteurs) ; $i++){
								try{
						$actVal = explode(" ", $acteurs[$i]['name']);
						
						if(acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]) == null ){
							addActeur($actVal[1],$actVal[0]);
						}
						
						$actId	= acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]);
						addListeActeur($id_film,$actId);
								}catch (Exception $e){
									echo "probleme détecter lors de l'ajout d'un acteur " ;
								}
					}
		
			for($i = 0 ; $i < count($genre) ; $i++){
				addCategorieFilm($genre[$i]);
				$id_cat = getCategorieFilmIdByLib($genre[$i]);
				addListeCategorieFilm($id_film, $id_cat);
			}
		
		}
		else if(isset($_POST['site_lib']) && $_POST['site_lib'] == 'allo'  && isset($_POST['film_id'])){
			
			require_once( dirname(__FILE__) . "/../api_allocine/api-allocine-helper-2.2.php") ;

			$helper = new AlloHelper;
			$code = $_POST['film_id'];
			$profile = 'large';
			
			try
			{
				// Envoi de la requête
				$movie = $helper->movie( $code, $profile );
				
				$title = $movie->originalTitle;
				$year = $movie->release['releaseDate'];
				$rating = $movie->statistics['userRating'];
				$genre = $movie->genre;
				$realisateur = $movie->castingShort['directors'];
				$resumer = $movie->synopsis;
				$acteurs = explode(", ", $movie->castingShort['actors']);
				$image = $movie->poster['href'];
				
				
				$url = $image;
				// Le chemin de sauvegarde
				$path = dirname(__FILE__) .'/../images';
				// On recup le nom du fichier
				$name = array_pop(explode('/',$url));
				// On copie le fichier
				copy($url,$path.'/'.$_POST['film_id'].'.jpg');
				
				///////////////////////ajout du film /////////////////////////////////
				//verifie si le realisateur à déja été ajouter
				try{
					$resVal = explode( " " ,$realisateur);
					if(!(getRealisateurIdByPrenom($resVal[0]) == null && getRealisateurIdByNom($resVal[1]) == null)){
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}else if (!(getRealisateurIdByNom($resVal[0]) == null && getRealisateurIdByPrenom($resVal[1]) == null)){
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}else{
						addRealisateur($resVal[1],$resVal[0]); //ajout du réalisateur si il est pas dans la bdd
						$resId = getRealisateurIdByPrenom($resVal[0]) ;
					}
				}catch(Exception $e) {
					echo "probleme détecter lors de l'ajout du realisateur " ;
					$resId = null ;
				}
				//ajout du film
				//date = 2012-05-09 Y-M-D
				
				addFilm($title,$year,$_POST['film_id'],$resId, null ,$resumer,null,null,null,null);
				
				$id_film=getFilmIdByTitre($title);
				
				//ajout acteur
				
				for($i = 0 ; $i < count($acteurs) ; $i++){
					try{
						$actVal = explode(" ", $acteurs[$i]);
				
						if(acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]) == null ){
							addActeur($actVal[1],$actVal[0]);
						}
				
						$actId	= acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]);
						addListeActeur($id_film,$actId);
					}catch (Exception $e){
						echo "probleme détecter lors de l'ajout d'un acteur " ;
					}
				}
				
				for($i = 0 ; $i < count($genre) ; $i++){
					addCategorieFilm($genre[$i]['$']);
					$id_cat = getCategorieFilmIdByLib($genre[$i]['$']);
					addListeCategorieFilm($id_film, $id_cat);
				}
			
			}
			catch( ErrorException $error )
			{
				// En cas d'erreur
				echo "Erreur n°", $error->getCode(), ": ", $error->getMessage(), PHP_EOL;
			}
		}
		return "rechercherFilm.php";
	}
	
	function processAjoutFilmByTitre()
	{
		return "rechercherFilm.php";
	}
	
	function processFilmStatistiques()
	{
		return "film_statistiques.php?film_id=".$_POST['film_id'];
	}

?>
