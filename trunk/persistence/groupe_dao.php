<?php

	include_once ('../orm/bootstrap.php');
	
	function addGroupe($groupe_lib)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getGroupeByLib($groupe_lib);
		if($isExisting == -1){
			$groupe = new Groupe();
			$groupe['groupe_lib'] = $groupe_lib;
			$groupe->save();
			return 1;
		}else{
			return -1;
		}		
	}
	
	function getGroupeById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = Doctrine_Core :: getTable ( 'Groupe' )->findBy('groupe_id', $id ,null);	
		$groupe = $groupe->getData();
		if(count($groupe) != 1)
			return -1;
		return $groupe;
	}
	
	function getGroupeByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = Doctrine_Core :: getTable ( 'Groupe' )->findBy('groupe_lib', $lib ,null);	
		$groupe = $groupe->getData();
		if(count($groupe) != 1)
			return -1;
		return $groupe;
	}
	
	function getGroupeIdByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = Doctrine_Core :: getTable ( 'Groupe' )->findBy('groupe_lib', $lib ,null);	
		$groupe = $groupe->getData();
		if(count($groupe) != 1)
			return -1;
		return $groupe['groupe_id'];
	}
	
	function getGroupeLibById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = Doctrine_Core :: getTable ( 'Groupe' )->findBy('groupe_id', $id ,null);	
		$groupe = $groupe->getData();
		if(count($groupe) != 1)
			return -1;
		return $groupe['groupe_lib'];
	}
	
	function getAllGroupe()
	{
		Doctrine_Core :: loadModels('./models');
		$listeGroupes = Doctrine_Core :: getTable ( 'Groupe' )->findAll(null);	
		$listeGroupes = $listeGroupes->getData();
		if(count($listeGroupes) == 0)
			return -1;
		return $listeGroupes;
	}
	
	function setGroupeLibById($id, $lib)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = getGroupeById($id);
		if($groupe != -1){
			$groupe['groupe_lib'] = $lib;
			$groupe->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteGroupeById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$groupe = getGroupeById($id);
		if($groupe != -1){
			$groupe->delete();
			return 1;
		}else{
			return -1;
		}
	}
	
	

?>