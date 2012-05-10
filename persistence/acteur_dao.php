<?php

	include_once ('./orm/bootstrap.php');
	
	function addActeur($nom, $prenom)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = new Acteur();
		$acteur['acteur_nom'] = $nom;
		$acteur['acteur_prenom'] = $prenom;
		$acteur->save();
	}
	
	function getActeurById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = Doctrine_Core :: getTable ( 'Acteur' )->findBy('acteur_id', $id ,null);	
		$acteur = $acteur->getData();
		if(count($acteur) != 1)
			return -1;
		return $acteur[0];
	}
	
	function getIdbyNom($nom){
		Doctrine_Core :: loadModels('./models');
		$acteur = Doctrine_Core :: getTable ( 'Acteur' )->findBy('acteur_nom', $nom ,null);	
		$acteur = $acteur->getData();
		if(count($acteur) != 1)
			return -1;
		return $acteur[0]['acteur_id'];
	}
	
	function getActeurNomById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = Doctrine_Core :: getTable ( 'Acteur' )->findBy('acteur_id', $id ,null);	
		$acteur = $acteur->getData();
		if(count($acteur) != 1)
			return -1;
		return $acteur[0]['acteur_nom'];
	}
	
	function getActeurPrenomById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = Doctrine_Core :: getTable ( 'Acteur' )->findBy('acteur_id', $id ,null);	
		$acteur = $acteur->getData();
		if(count($acteur) != 1)
			return -1;
		return $acteur[0]['acteur_prenom'];
	}
	
	function setActeurNomById($id, $nom)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = getActeurById($id);
		if($acteur != -1){
			$acteur['acteur_nom'] = $nom;
			$acteur->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function setActeurPrenomById($id, $prenom)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = getActeurById($id);
		if($acteur != -1){
			$acteur['acteur_prenom'] = $prenom;
			$acteur->save();
			return 1;
		}else{
			return -1;
		}
	}
	
	function deleteActeurById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$acteur = getActeurById($id);
		if($acteur != -1){
			$acteur->delete();
			return 1;
		}else{
			return -1;
		}
	}
	
	function acteur_getIdbyNomEtPrenom($nom,$prenom){
		$requete = Doctrine_Query::create()
		   		
		  			->from('Acteur')
		   			->where('acteur_nom ="'.$prenom.'"') 
		   			->andWhere('acteur_prenom="'.$nom.'"')
					->orWhere('acteur_prenom="'.$prenom.'"')
					->andWhere('acteur_nom="'.$nom.'"')
		   			->execute();
					
			if(count($requete) != 1)			
				return -1 ;
			
			return $requete[0]['acteur_id']; //retourne l'id de l'acteur				
	}
	
?>