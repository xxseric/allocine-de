<?php

	include_once ('../orm/bootstrap.php');
	
	function addRecompense($recompense_lib)
	{
		Doctrine_Core :: loadModels('../models');
		$isExisting = getRecompenseByLib($recompense_lib);
		if($isExisting == -1){
			$recompense = new Recompense();
			$recompense['recompense_lib'] = $recompense_lib;
			$recompense->save();
			return 1;
		}else{
			return -1;
		}		
	}
	
	function getRecompenseById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_id', $id ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return -1;
		return $recompense;
	}
	
	function getRecompenseByLib($lib)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_lib', $lib ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return -1;
		return $recompense;
	}
	
	function getRecompenseIdByLib($lib)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_lib', $lib ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return -1;
		return $recompense['recompense_id'];
	}
	
	function getRecompenseLibById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = Doctrine_Core :: getTable ( 'Recompense' )->findBy('recompense_id', $id ,null);	
		$recompense = $recompense->getData();
		if(count($recompense) != 1)
			return -1;
		return $recompense['recompense_lib'];
	}
	
	function setRecompenseLibById($id, $lib)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = getRecompenseById($id);
		if($recompense != -1){
			$recompense['recompense_lib'] = $lib;
			$recompense->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteRecompenseById($id)
	{
		Doctrine_Core :: loadModels('../models');
		$recompense = getRecompenseById($id);
		if($recompense != -1){
			$recompense->delete();
			return 1;
		}else{
			return -1;
		}
	}

?>