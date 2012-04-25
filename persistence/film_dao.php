<?php

	include_once ('../orm/bootstrap.php');
	require_once 'listeActeur_dao.php';
	require_once 'listeCategoriesFilm_dao.php';
	require_once 'listeRecompenses_dao.php';
	
	function addFilm($titre, $date, $resume=null, $image_id, $realisateur_id, $site_id, $site_note, $listeActeurs, $listeCategorie, $listeRecompenses)
	{
		Doctrine_Core :: loadModels('../models');
		$isExisting = getFilmByTitre($titre);
		if(count($isExisting) == 0){
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
				foreach ($listeCategorie as $categorie)
					addListeCategorieFilm($film_id, $categorie['catFilm_id']);
			}
			if(count($listeRecompenses) > 0){
				foreach ($listeRecompenses as $recompense)
					addListeRecompenses($film_id, $recompense['recompense_id']);
			}
			return 1;
		}else{
			return -1;
		}		
	}

	function getFilmById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_id', $id ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return -1;
		return $film;
	}
	
	function getFilmByTitre($titre)
	{
		Doctrine_Core :: loadModels('../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_titre', $titre ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return -1;
		return $film;
	}
	
	function getFilmIdByTitre($titre)
	{
		Doctrine_Core :: loadModels('../models');
		$film = Doctrine_Core :: getTable ( 'Film' )->findBy('film_titre', $titre ,null);	
		$film = $film->getData();
		if(count($film) != 1)
			return -1;
		return $film['film_id'];
	}
	
	function getAllFilms()
	{
		Doctrine_Core :: loadModels('../models');
		$listeFilms = Doctrine_Core :: getTable ( 'Film' )->findAll(null);	
		$listeFilms = $listeFilms->getData();
		if(count($listeFilms) == 0)
			return -1;
		return $listeFilms;
	}
	
	function getFilmCategoriesIdById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeCategories = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $id ,null);	
		$listeCategories = $listeCategories->getData();
		if(count($listeCategories) == 0)
			return -1;
		return $listeCategories['listeCategoriesFilms_id'];
	}
	
	function getFilmRealisateurIdById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$realisateur = Doctrine_Core :: getTable ( 'Film' )->findBy('film_id', $id ,null);	
		$realisateur = $realisateur->getData();
		if(count($realisateur) == 0)
			return -1;
		return $realisateur['film_realisateur_id'];
	}
	
	function getFilmActeursIdById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeActeurs = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_film_id', $id ,null);	
		$listeActeurs = $listeActeurs->getData();
		if(count($listeActeurs) == 0)
			return -1;
		return $listeActeurs['listeActeur_id'];
	}
	
	function setFilmTitreById($id, $titre)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film['film_titre'] = $titre;
			$film->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function setFilmDateById($id, $date)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film['film_date'] = $date;
			$film->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function setFilmResumeById($id, $resume)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film['film_resume'] = $resume;
			$film->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function setFilmImageIdById($id, $image_id)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film['film_image_id'] = $image_id;
			$film->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function setFilmRealisateurIdById($id, $realisateur_id)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film['film_realisateur_id'] = $realisateur_id;
			$film->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function deleteFilmById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmById($id);
		if($film != -1){
			$film->delete();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function deleteFilmByTitre($titre)
	{
		Doctrine_Core :: loadModels('../models');
		$film = getFilmByTitre($titre);
		if($film != -1){
			$film->delete();
			return 1;
		}else{
			return -1;
		}	
	}

?>