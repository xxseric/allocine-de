<?php

	include_once ('orm/bootstrap.php');
	
	function addCategorieFilm($categorie_film_lib)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getCategorieFilmByLib($categorie_film_lib);
		if(!is_object($isExisting)){
			$catFilm = new CategorieFilm();
			$catFilm['catFilm_libelle'] = $categorie_film_lib;
			$catFilm->save();
			return 1;
		}else{
			return -1;
		}		
	}
	
	function getCategorieFilmById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = Doctrine_Core :: getTable ( 'CategorieFilm' )->findBy('catFilm_id', $id ,null);	
		$catFilm = $catFilm->getData();
		if(count($catFilm) != 1)
			return -1;
		return $catFilm[0];
	}
	
	function getCategorieFilmByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = Doctrine_Core :: getTable ( 'CategorieFilm' )->findBy('catFilm_libelle', $lib ,null);	
		$catFilm = $catFilm->getData();
		if(count($catFilm) != 1)
			return -1;
		return $catFilm[0];
	}
	
	function getCategorieFilmIdByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = Doctrine_Core :: getTable ( 'CategorieFilm' )->findBy('catFilm_libelle', $lib ,null);	
		$catFilm = $catFilm->getData();
		if(count($catFilm) != 1)
			return -1;
		return $catFilm[0]['catFilm_id'];
	}
	
	function getCategorieFilmLibById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = Doctrine_Core :: getTable ( 'CategorieFilm' )->findBy('catFilm_id', $id ,null);	
		$catFilm = $catFilm->getData();
		if(count($catFilm) != 1)
			return -1;
		return $catFilm[0]['catFilm_libelle'];
	}
	
	function getAllCategories()
	{
		Doctrine_Core :: loadModels('./models');
		$listeCategories = Doctrine_Core :: getTable ( 'CategorieFilm' )->findAll(null);	
		$listeCategories = $listeCategories->getData();
		if(count($listeCategories) == 0)
			return -1;
		$liste = array();
		foreach ($listeCategories as $categorie)
			$liste[] = $categorie;
		return $liste;
	}
	
	function setCategorieFilmLibById($id, $lib)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = getCategorieFilmById($id);
		if($catFilm != -1){
			$catFilm['catFilm_libelle'] = $lib;
			$catFilm->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteCategorieFilmById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$catFilm = getCategorieFilmById($id);
		if($catFilm != -1){
			$catFilm->delete();
			return 1;
		}else{
			return -1;
		}
	}
	
	

?>