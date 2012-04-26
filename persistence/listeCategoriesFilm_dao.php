<?php

	
	function addListeCategorieFilm($film_id, $categorie_film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getListeCategorieFilmByFilmIdAndCategorieId($film_id, $categorie_film_id);
		if(null && $isExisting == -1){
			$listeCategoriesFilm = new ListeCategoriesFilm();
			$listeCategoriesFilm['listeCategoriesFilms_film_id'] = $film_id;
			$listeCategoriesFilm['listeCategoriesFilms_categorie_film'] = $categorie_film_id;
			$listeCategoriesFilm->save();
			return 1;
		}else{
			return -1;
		}
	}	
	
	function getListeCategorieFilmById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_id', $id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return -1;
		return $listeCategoriesFilm;
	}
	
	function getListeCategorieFilmByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_film_id', $id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return -1;
		return $listeCategoriesFilm;
	}
	
	function getListeCategorieFilmByCategorieFilmId($categorie_film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategoriesFilm = Doctrine_Core :: getTable ( 'ListeCategoriesFilm' )->findBy('listeCategoriesFilms_categorie_film', $categorie_film_id ,null);	
		$listeCategoriesFilm = $listeCategoriesFilm->getData();
		if(count($listeCategoriesFilm) == 0)
			return -1;
		return $listeCategoriesFilm;
	}
	
	function getListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
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
			return -1;
	}
	
	function deleteListeRecompensesById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategories = getListeCategorieFilmById($id);
		if(count($listeCategories) == 1){
			$listeCategories->delete();
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeCategorieFilmByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategories = getListeCategorieFilmByFilmId($film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeCategorieFilmByCategorieFilmId($categorie_film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategories = getListeCategorieFilmByCategorieFilmId($categorie_film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategories = getListeCategorieFilmByFilmIdAndCategorieFilmId($film_id, $categorie_film_id);
		if(count($listeCategories) > 0){
			foreach ($listeCategories as $categorieFilm){
				$categorieFilm->delete();	
			}
			return 1;
		}
		else
			return -1;
	}

?>