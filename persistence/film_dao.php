<?php

	include_once ( dirname(__FILE__) . '/../orm/bootstrap.php');
	require_once 'listeActeur_dao.php';
	require_once 'listeCategoriesFilm_dao.php';
	require_once 'listeRecompenses_dao.php';
	require_once 'note_dao.php';
	require_once 'filmFavoris_dao.php';
	
	function addFilm($titre, $date,  $image_id, $realisateur_id, $listeActeurs,$resume=null, $listeCategorie=0, $listeRecompenses=0 , $site_id=null, $site_note=null )
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$isExisting = getFilmByTitre($titre);
		
		if(!is_object($isExisting)){
			$film = new Film();
			$film['film_titre'] = $titre;
			$film['film_date'] = $date;
			$film['film_resume'] = $resume;
			$film['film_image_id'] = $image_id;
			$film['film_realisateur_id'] = $realisateur_id;
			$film['film_site_id'] = $site_id;
			$film['film_site_note'] = $site_note;
			$film->save();
			$film_id = getFilmIdByTitre($titre);
			if(count($listeActeurs) > 0){
				foreach ($listeActeurs as $acteur)
					addListeActeur($film_id, $acteur['acteur_id']);
			}
			if(count($listeCategorie) > 0){
				for($i =0 ; $i < count($listeCategorie) ; $i++)
					addListeCategorieFilm($film_id, $listeCategorie[$i]);
			}
			if(count($listeRecompenses) > 0){
				foreach ($listeRecompenses as $recompense)
					addListeRecompenses($film_id, $recompense['recompense_id']);
			}
			return 1;
		}else{
			return null;
		}		
	}

	
	function getFilmById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_id', $id ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return null;
		return $film[0];
	}
	
	function getFilmByTitre($titre)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_titre', $titre ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return null;
		return $film[0];
	}
	
	function getFilmByRealisateurId($realisateur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$liste_films = Doctrine_Core :: getTable ( 'Film' )->findBy('film_realisateur_id', $realisateur_id ,null);	
		$liste_films = $liste_films->getData();
		if(count($liste_films) == 0){
			return null;
		}else{
			return $liste_films;
		}
	}
	
	function getFilmByActeurId($acteur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$liste_acteurs = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_acteur_id', $acteur_id ,null);	
		$liste_acteurs = $liste_acteurs->getData();
		if(count($liste_acteurs) == 0){
			return null;
		}else if(count($liste_acteurs) == 1){
			$film = array();
			$film[] = getFilmById($liste_acteurs[0]['listeActeur_film_id']);
			return $film;
		}else{
			$liste_films = array();
			foreach ($liste_acteurs as $l_acteurs) {
				$liste_films[] = getFilmById($l_acteurs['listeActeur_film_id']);
			}
			return $liste_films;
		}
	}
	

	function getFilmIdByTitre($titre)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_titre', $titre ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return null;
		return $film[0]['film_id'];
	}


			 
	function film_getListeCategorieFilmByCategorieFilmId($categorie_film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_categorie_film', $categorie_film_id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return null;
		return $listeCategoriesFilm;
	}
	
	function film_getListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
	{
		$listeCategoriesFilmByFilmId = getListeCategorieFilmByFilmId($film_id);	
		if(count($listeCategoriesFilmByFilmId) > 0){
			$listeCategories = array();
			foreach ($listeCategoriesFilmByFilmId as $categorieFilm){
				if($categorieFilm['listeCategoriesFilms_categorie_film'] == $categorie_film_id){
					$listeCategories[] = $categorieFilm;
				}
			}
			return $listeCategories;
		}
		else
			return null;
	}
	
	function film_deleteListeRecompensesById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = getListeCategorieFilmById($id);
		if(count($listeCategories) == 1){
			$listeCategories->delete();
			return 1;
		}
		else
			return null;
	}
	
	function film_deleteListeCategorieFilmByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = getListeCategorieFilmByFilmId($film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return null;
	}
	
	function film_deleteListeCategorieFilmByCategorieFilmId($categorie_film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = getListeCategorieFilmByCategorieFilmId($categorie_film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return null;
	}
	
	function film_deleteListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = getListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return null;
	}
	
	function getAllFilms()
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeFilms = Doctrine_Core :: getTable ( 'Film' )->findAll(null);	
		$listeFilms = $listeFilms->getData();
		if(count($listeFilms) == 0)
			return null;
		$liste = array();
		foreach ($listeFilms as $film)
			$liste[] = $film;
		return $liste;
	}
	
	function getFilmByCategorie($id_categorie){
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeIdFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_categorie_film', $id_categorie ,null);	
		$listeFilm = array();
		for($i = 0 ; $i < count($listeIdFilm) ; $i++ ){
			$listeFilm[$i] = getFilmById($listeIdFilm[$i]['listeCategoriesFilms_film_id']);	
		}
		
		if(count($listeFilm) == 0){
			return null;
		}else {
			return $listeFilm ;
		}
	}
	
	function getFilmCategoriesIdById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $id ,null);	
		$listeCategories = $listeCategories->getData();
		if(count($listeCategories) == 0)
			return null;
		return $listeCategories['listeCategoriesFilms_id'];
	}
	
	function getFilmRealisateurIdById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Film' )->findBy('film_id', $id ,null);	
		
		if(count($realisateur) == 0)
			return null;
		return $realisateur[0]['film_realisateur_id'];
	}
	
	function getFilmActeursIdById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeurs = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_film_id', $id ,null);	
		$listeActeurs = $listeActeurs->getData();
		if(count($listeActeurs) == 0)
			return null;
		return $listeActeurs['listeActeur_id'];
	}
	
	function getFilmImageIdById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeurs = Doctrine_Core :: getTable ( 'Film' )->findBy('film_id', $id ,null);	
	
		if(count($listeActeurs) == 0)
			return null;
		return $listeActeurs[0]['film_image_id'];
	}
	
	function setFilmTitreById($id, $titre)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		if(count($film) > 0){
			$film['film_titre'] = $titre;
			$film->save();
			return 1;
		}else{
			return null;
		}	
	}
	
	function setFilmDateById($id, $date)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		if(count($film) > 0){
			$film['film_date'] = $date;
			$film->save();
			return 1;
		}else{
			return null;
		}	
	}
	
	function setFilmResumeById($id, $resume)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		if(count($film) > 0){
			$film['film_resume'] = $resume;
			$film->save();
			return 1;
		}else{
			return null;
		}	
	}
	
	function setFilmImageIdById($id, $image_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		if(count($film) > 0){
			$film['film_image_id'] = $image_id;
			$film->save();
			return 1;
		}else{
			return null;
		}	
	}
	
	function setFilmRealisateurIdById($id, $realisateur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		if(count($film) > 0){
			$film['film_realisateur_id'] = $realisateur_id;
			$film->save();
			return 1;
		}else{
			return null;
		}	
	}
	
	function deleteFilmById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmById($id);
		
		if(count($film) > 0){
			$film->delete();
			return 1;
		}else{
			return null;
		}	
	}
	
	function deleteFilmByTitre($titre)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film = getFilmByTitre($titre);
		if(count($film) > 0){
			$film->delete();
			return 1;
		}else{
			return null;
		}	
	}


?>