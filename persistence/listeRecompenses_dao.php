<?php

	
	function addListeRecompenses($film_id, $recompense_id)
	{
		Doctrine_Core :: loadModels('../models');
		$isExisting = getListeRecompensesByFilmIdAndRecompenseId($film_id, $recompense_id);
		if($user_id != null && $isExisting == -1){
			$listeRecompenses = new ListeRecompenses();
			$listeRecompenses['listeRecompense_film_id'] = $film_id;
			$listeRecompenses['listeRecompense_recompense_id'] = $recompense_id;
			$listeRecompenses->save();
			return 1;
		}else{
			return -1;
		}
	}	
	
	function getListeRecompensesById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = Doctrine_Core :: getTable ( 'ListeRecompenses' )->findBy('listeRecompense_id', $id ,null);	
		$listeRecompenses = $listeRecompenses->getData();
		if(count($listeRecompenses) == 0)
			return -1;
		return $listeRecompenses;
	}
	
	function getListeRecompensesByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = Doctrine_Core :: getTable ( 'ListeRecompenses' )->findBy('listeRecompense_film_id', $film_id ,null);	
		$listeRecompenses = $listeRecompenses->getData();
		if(count($listeRecompenses) == 0)
			return -1;
		return $listeRecompenses;
	}
	
	function getListeRecompensesByRecompenseId($recompense_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = Doctrine_Core :: getTable ( 'ListeRecompenses' )->findBy('listeRecompense_recompense_id', $recompense_id ,null);	
		$listeRecompenses = $listeRecompenses->getData();
		if(count($listeRecompenses) == 0)
			return -1;
		return $listeRecompenses;
	}
	
	function getListeRecompensesByFilmIdAndRecompenseId($film_id, $recompense_id)
	{
		$listeRecompensensByFilmId = getListeRecompensesByFilmId($film_id);	
		if(count($listeRecompensensByFilmId) > 0){
			$listeRecompenses = array();
			foreach ($listeRecompensensByFilmId as $recompense){
				if($recompense['listeRecompense_recompense_id'] == $recompense_id){
					$listeRecompenses[] = $recompense;
				}
			}
			return $listeRecompenses;
		}
		else
			return -1;
	}
	
	function deleteListeRecompensesById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = getListeRecompensesById($id);
		if(count($listeRecompenses) == 1){
			$listeRecompenses->delete();
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeRecompensesByFilmId($film_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = getListeRecompensesByFilmId($film_id);
		if(count($listeRecompenses) > 0){
			foreach ($listeRecompenses as $recompense){
				$recompense->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeRecompensesByRecompenseId($recompense_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = getListeRecompensesByRecompenseId($recompense_id);
		if(count($listeRecompenses) > 0){
			foreach ($listeRecompenses as $recompense){
				$recompense->delete();	
			}
			return 1;
		}
		else
			return -1;
	}
	
	function deleteListeRecompensesByFilmIdAndRecompenseId($film_id, $recompense_id)
	{
		Doctrine_Core :: loadModels('../models');
		$listeRecompenses = getListeRecompensesByFilmIdAndRecompenseId($film_id, $recompense_id);
		if(count($listeRecompenses) == 1){
			$listeRecompenses->delete();
			return 1;
		}
		else
			return -1;
	}

?>