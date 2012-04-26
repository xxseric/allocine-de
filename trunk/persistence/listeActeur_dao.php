<?php

	
	function addListeActeur($film_id, $acteur_id)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getListeActeurByFilmIdAndActeurId($film_id, $acteur_id);
		if(null && $isExisting == -1){
			$listeActeur = new ListeActeur();
			$listeActeur['listeActeur_film_id'] = $film_id;
			$listeActeur['listeActeur_acteur_id'] = $acteur_id;
			$listeActeur->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function getListeActeurById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_id', $id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return -1;
		return $listeActeur;
	}
	
	function getListeActeurByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_film_id', $film_id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return -1;
		return $listeActeur;
	}
	
	function getListeActeurByActeurId($acteur_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = Doctrine_Core :: getTable ( 'ListeActeur' )->findBy('listeActeur_acteur_id', $acteur_id ,null);	
		$listeActeur = $listeActeur->getData();
		if(count($listeActeur) == 0)
			return -1;
		return $listeActeur;
	}
	
	function getListeActeurByFilmIdAndActeurId($film_id, $acteur_id)
	{
		$listeActeurByFilmId = getListeActeurByFilmId($film_id);	
		if(count($listeActeurByFilmId) > 0){
			$listeActeur = array();
			foreach ($listeActeurByFilmId as $acteur){
				if($acteur['listeActeur_acteur_id'] == $acteur_id){
					$listeActeur[] = $acteur_id;
				}
			}
			return $listeActeur;
		}
		else
			return -1;
	}
	
	function deleteListeActeurById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = getListeActeurById($id);
		if(count($listeActeur) == 1){
			$listeActeur->delete();
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeActeurByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = getListeActeurByFilmId($film_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeActeurByActeurId($acteur_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = getListeActeurByActeurId($acteur_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeActeurByFilmIdAndActeurId($film_id, $acteur_id)
	{
		Doctrine_Core :: loadModels('./models');
		$listeActeur = getListeActeurByFilmIdAndActeurId($film_id, $acteur_id);
		if(count($listeActeur) > 0){
			foreach ($listeActeur as $acteur){
				$acteur->delete();	
			}
			return 1;
		}
		else
			return -1;
	}

?>