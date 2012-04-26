<?php

	include_once ('../orm/bootstrap.php');
	
	function addSite($site_lib)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getSiteByLib($site_lib);
		if($isExisting == -1){
			$site = new Site();
			$site['site_lib'] = $site_lib;
			$site->save();
			return 1;
		}else{
			return -1;
		}		
	}
	
	function getSiteById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$site = Doctrine_Core :: getTable ( 'Site' )->findBy('site_id', $id ,null);	
		$site = $site->getData();
		if(count($site) != 1)
			return -1;
		return $site;
	}
	
	function getSiteByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$site = Doctrine_Core :: getTable ( 'Site' )->findBy('site_lib', $lib ,null);	
		$site = $site->getData();
		if(count($site) != 1)
			return -1;
		return $site;
	}
	
	function getSiteIdByLib($lib)
	{
		Doctrine_Core :: loadModels('./models');
		$site = Doctrine_Core :: getTable ( 'Site' )->findBy('site_lib', $lib ,null);	
		$site = $site->getData();
		if(count($site) != 1)
			return -1;
		return $site['site_id'];
	}
	
	function getSiteLibById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$site = Doctrine_Core :: getTable ( 'Site' )->findBy('site_id', $id ,null);	
		$site = $site->getData();
		if(count($site) != 1)
			return -1;
		return $site['site_lib'];
	}
	
	function getAllSite()
	{
		Doctrine_Core :: loadModels('./models');
		$listeSites = Doctrine_Core :: getTable ( 'Site' )->findAll(null);	
		$listeSites = $listeSites->getData();
		if(count($listeSites) == 0)
			return -1;
		return $listeSites;
	}
	
	function setSiteLibById($id, $lib)
	{
		Doctrine_Core :: loadModels('./models');
		$site = getSiteById($id);
		if($site != -1){
			$site['site_lib'] = $lib;
			$site->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteSiteById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$site = getSiteById($id);
		if($site != -1){
			$site->delete();
			return 1;
		}else{
			return -1;
		}
	}

?>