<?php

	include_once ( dirname(__FILE__) . '/../orm/bootstrap.php');
	
	function addFavoris($film_id, $user_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$isExisting = getFilmFavorisByFilmIdAndUserId($film_id, $user_id);
		if($isExisting == null){
			$film_favoris = new FilmFavoris();
			$film_favoris['film_id'] = $film_id;
			$film_favoris['user_id'] = $user_id;
			$film_favoris->save();
			return 1;
		}else{
			return null;
		}		
	}
	
	function getFilmFavorisById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film_favoris = Doctrine_Core :: getTable ( 'FilmFavoris' )->findBy('film_favoris_id', $id ,null);	
		$film_favoris = $film_favoris->getData();
		if(count($film_favoris) != 1)
			return null;
		return $film_favoris[0];
	}
	
	function getFilmFavorisByUserId($user_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film_favoris = Doctrine_Core :: getTable ( 'FilmFavoris' )->findBy('user_id', $user_id ,null);	
		$film_favoris = $film_favoris->getData();
		if(count($film_favoris) == 0)
			return null;
		else if(count($film_favoris) > 1){
			return $film_favoris;
		}
		return $film_favoris;
	}
	
	function getFilmFavorisByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film_favoris = Doctrine_Core :: getTable ( 'FilmFavoris' )->findBy('film_id', $film_id ,null);	
		$film_favoris = $film_favoris->getData();
		if(count($film_favoris) != 1)
			return null;
		else if(count($film_favoris) > 1){
			$liste = array();
			foreach ($film_favoris as $film){
				$liste[] = $film[0];
			}
			return $liste;
		}
		return $film_favoris[0];
	}
	
	function getFilmFavorisByFilmIdAndUserId($film_id, $user_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$film_favoris = Doctrine_Core :: getTable ( 'FilmFavoris' )->findBy('film_id', $film_id ,null);	
		$film_favoris = $film_favoris->getData();
		if(count($film_favoris) == 0)
			return null;
		else if(count($film_favoris) == 1 && $film_favoris[0]['user_id'] == $user_id)
			return $film_favoris[0];
		else if(count($film_favoris) > 1){
			$liste = array();
			foreach($film_favoris as $film){
				if($film[0]['user_id'] == $user_id)
					$liste = $film[0];
			}
			return $liste;
		}
	}
	
	function deleteFilmFavorisById($id)
	{
		$film = getFilmFavorisById($id);
		if($film != null){
			$film->delete();
			return 1;
		}
		else 
			return null;
	}
	
	function deleteFilmFavorisByFilmIdAndUserId($film_id, $user_id)
	{
		$film = getFilmFavorisByFilmIdAndUserId($film_id, $user_id);
		if(count($film) == 1){
			$film->delete();
			return 1;
		}
		else 
			return null;
	}

?>