<?php

	include_once (dirname(__FILE__) . '/../orm/bootstrap.php');
	
	function addRecompense($recompense_lib)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$isExisting = getRecompenseByLib($recompense_lib);
		if($isExisting == -1){
			$recompense = new Recompense();
			$recompense['recompense_lib'] = $recompense_lib;
			$recompense->save();
			return 1;
		}else{
			return null;
		}		
	}
	
	function getRecompenseById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_id', $id ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return null;
		return $recompense;
	}
	
	function getRecompenseByLib($lib)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_lib', $lib ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return null;
		return $recompense;
	}
	
	function getRecompenseIdByLib($lib)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_lib', $lib ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return null;
		return $recompense['recompense_id'];
	}
	
	function getRecompenseLibById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_id', $id ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return null;
		return $recompense['recompense_lib'];
	}
	
	function getAllRecompenses()
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeRecompenses = Doctrine_Core :: getTable ( 'Recompense' )->findAll(null);	
		$listeRecompenses = $listeRecompenses->getData();
		if(count($listeRecompenses) == 0)
			return null;
		return $listeRecompenses;
	}
	
	function setRecompenseLibById($id, $lib)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = getRecompenseById($id);
		if($recompense != -1){
			$recompense['recompense_lib'] = $lib;
			$recompense->save();
			return 1;
		}else{
			return null;
		}
	}
	
	function deleteRecompenseById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$recompense = getRecompenseById($id);
		if($recompense != -1){
			$recompense->delete();
			return 1;
		}else{
			return null;
		}
	}

?>