<?php

	include_once (dirname(__FILE__) . '/../orm/bootstrap.php');
	
	function addRealisateur($realisateur_nom, $realisateur_prenom)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = new Realisateur();
		$realisateur['realisateur_nom'] = $realisateur_nom;
		$realisateur['realisateur_prenom'] = $realisateur_prenom;
		$realisateur->save();
		return 1;		
	}
	
	function getRealisateurIdByNom($nom){
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_nom', $nom ,null);	
		$realisateur = $realisateur->getData();		
		if(count($realisateur) != 1)
			return null;
		return $realisateur[0]['realisateur_id'];
	}
	
	function getRealisateurIdByPrenom($prenom){
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_prenom', $prenom ,null);
		$realisateur = $realisateur->getData();			
		if(count($realisateur) != 1)
			return null;
		return $realisateur[0]['realisateur_id'];
	}
	
	function getRealisateurIdByNomAndPrenom($nom, $prenom){
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_prenom', $prenom ,null);
		$realisateur = $realisateur->getData();			
		if(count($realisateur) > 1){
			foreach ($realisateur as $real){
				if($real['realisateur_nom'] == $nom)
					return $real[0]['realisateur_id'];
			}
		}
		else if(count($realisateur) == 1 && $realisateur[0]['realisateur_nom'] == $nom)
			return $realisateur[0]['realisateur_id'];
		return null;
	}
	
	function getRealisateurById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_id', $id ,null);	
		$realisateur = $realisateur->getData();
		if(count($realisateur) != 1)
			return null;
		return $realisateur[0];
	}
	
	function getRealisateurNomById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_id', $id ,null);	
		$realisateur = $realisateur->getData();
		if(count($realisateur) != 1)
			return null;
		return $realisateur[0]['realisateur_nom'];
	}
	
	function getRealisateurPrenomById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = Doctrine_Core :: getTable ( 'Realisateur' )->findBy('realisateur_id', $id ,null);	
		$realisateur = $realisateur->getData();
		if(count($realisateur) != 1)
			return null;
		return $realisateur[0]['realisateur_prenom'];
	}
	
	function getAllRealisateurs()
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$listeRealisateurs = Doctrine_Core :: getTable ( 'Realisateur' )->findAll(null);	
		$listeRealisateurs = $listeRealisateurs->getData();
		if(count($listeRealisateurs) == 0)
			return null;
		$liste = array();
		foreach ($listeRealisateurs as $realisateur){
			$liste[] = $realisateur[0];
		}
		return $liste;
	}
	
	function setRealisateurNomById($id, $realisateur_nom)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = getRealisateurById($id);
		if($realisateur != -1){
			$realisateur['realisateur_nom'] = $realisateur_nom;
			$realisateur->save();
			return 1;
		}else{
			return null;
		}
	}
	
	function setRealisateurPrenomById($id, $realisateur_prenom)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = getRealisateurById($id);
		if($realisateur != -1){
			$realisateur['realisateur_prenom'] = $realisateur_prenom;
			$realisateur->save();
			return 1;
		}else{
			return null;
		}
	}
	
	function deleteRealisateurById($id)
	{
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
		$realisateur = getRealisateurById($id);
		if($realisateur != -1){
			$realisateur->delete();
			return 1;
		}else{
			return null;
		}
	}

?>