<?php


include_once (dirname(__FILE__) . '/../orm/bootstrap.php');
	
	function addListeActeur($film_id, $acteur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
	/*	$isExisting = getListeActeurByFilmIdAndActeurId($film_id, $acteur_id);
		if( $isExisting == -1){*/
			$listeActeur = new ListeActeur();
			$listeActeur['listeActeur_film_id'] = $film_id;
			$listeActeur['listeActeur_acteur_id'] = $acteur_id;
			$listeActeur->save();
	/*		return 1;
		}else{
			return null;
		}*/
	}
	
	function getListeActeurById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_id', $id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return null;
		return $listeActeur;
	}
	
	function getListeActeurByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_film_id', $film_id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return null;
		else if(count($listeActeur) > 1){
			$liste = array();
			foreach ($listeActeur as $acteur)
				$liste[] = $acteur;
			return $liste;
		}
		return $listeActeur;
	}
	
	function getListeActeurByActeurId($acteur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_acteur_id', $acteur_id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return null;
		return $listeActeur;
	}
	
	function getListeActeurByFilmIdAndActeurId($film_id, $acteur_id)
	{
		$listeActeurByFilmId = getListeActeurByFilmId($film_id);	
		if(is_object($listeActeurByFilmId)){
			$listeActeur = array();
			foreach ($listeActeurByFilmId as $acteur){
				if($acteur['listeActeur_acteur_id'] == $acteur_id){
					$listeActeur[] = $acteur_id;
				}
			}
			return $listeActeur;
		}
		else
			return null;
	}
	
	function deleteListeActeurById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = getListeActeurById($id);
		if(count($listeActeur) == 1){
			$listeActeur->delete();
			return 1;
		}
		else
			return null;
	}
	
	function deleteListeActeurByFilmId($film_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = getListeActeurByFilmId($film_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return null;
	}
	
	function deleteListeActeurByActeurId($acteur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = getListeActeurByActeurId($acteur_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return null;
	}
	
	function deleteListeActeurByFilmIdAndActeurId($film_id, $acteur_id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeActeur = getListeActeurByFilmIdAndActeurId($film_id, $acteur_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return null;
	}

?>