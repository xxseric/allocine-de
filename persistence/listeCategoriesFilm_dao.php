<?php

	include_once (dirname(__FILE__) . '/../orm/bootstrap.php');
	

	function addListeCategorieFilm($film_id, $categorie_film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$isExisting = getListeCategorieFilmByFilmIdAndCategorieId($film_id, $categorie_film_id);
	
		if($isExisting != -1){
			$listeCategoriesFilm = new ListeCategoriesFilm();
			$listeCategoriesFilm['listeCategoriesFilms_film_id'] = $film_id;
			$listeCategoriesFilm['listeCategoriesFilms_categorie_film'] = $categorie_film_id;
			$listeCategoriesFilm->save();
			return 1;
		}else{
			return null;
		}
	}	
	
	function	getListeCategorieFilmByFilmIdAndCategorieId($id , $cat_id){
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $id ,null);	
		
		foreach ($listeCategoriesFilm as $categorie){
			if($categorie['listeCategoriesFilms_categorie_film'] == $cat_id){
				return null ;
			}
		}
		
		return 1 ;
	}
	
	function getListeCategorieFilmById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_id', $id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return null;
		return $listeCategoriesFilm[0];
	}
	
	function getListeCategorieFilmByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $film_id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0){
			return null;
		}else if(count($listeCategoriesFilm) > 1){
			$liste = array();
			foreach ($listeCategoriesFilm as $categorie){
				$liste[] = $categorie;
			}
			return $liste;
		}
		return $listeCategoriesFilm;
	}
	
	function getListeCategorieFilmByCategorieFilmId($categorie_film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_categorie_film', $categorie_film_id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return null;
		foreach ($listeCategoriesFilm as $categorie){
			$liste[] = $categorie;
		}
		return $liste;
	}
	
	function getListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
	{
		$listeCategoriesFilmByFilmId = getListeCategorieFilmByFilmId($film_id);	
		if(count($listeCategoriesFilmByFilmId) > 0){
			$listeCategories = array();
			foreach ($listeCategoriesFilmByFilmId as $categorieFilm){
				if($categorieFilm['listeCategoriesFilms_categorie_film'] == $categorie_film_id){
					$listeCategories[] = $categorieFilm;
					break;
				}
			}
			return $listeCategories;
		}
		else
			return null;
	}
	
	function deleteListeCategorieFilmByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeCategories = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $film_id ,null);	
		$listeCategories = $listeCategories->getData();
		if(count($listeCategories) > 1){
			foreach ($listeCategories as $categorieFilm){
				echo "2";
				$categorieFilm->delete();	
			}
			return 1;
		}else if(count($listeCategories) == 1){
			$film = $listeCategories[0];
			echo $film['listeCategoriesFilms_id'];
			$film->delete();
			return 1;
		}			
		else
			return null;
	}
	
	function deleteListeCategorieFilmByCategorieFilmId($categorie_film_id)
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
	
	function deleteListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
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

?>