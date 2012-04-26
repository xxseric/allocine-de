<?php

	include_once 'orm/bootstrap.php';
	
	function addUser($user_nom, $user_prenom, $user_num_rue=null, $user_lib_rue=null, $user_cp=null, $user_ville=null, $user_telephone=null, $user_email, $user_mdp, $user_groupe_id=null, $user_level=1)
	{
		Doctrine_Core :: loadModels('./models');
		$isExisting = getUserIdByEmail($user_email);
		if($isExisting == -1){
			$user = new User();
			$user['user_nom'] = $user_nom;
			$user['user_prenom'] = $user_prenom;
			$user['user_num_rue'] =  $user_num_rue;
			$user['user_lib_rue'] =  $user_lib_rue;
			$user['user_cp'] =  $user_cp;
			$user['user_ville'] =  $user_ville;
			$user['user_telephone'] =  $user_telephone;
			$user['user_email'] =  $user_email;
			$user['user_mdp'] = md5($user_mdp);
			$user['user_groupe_id'] = $user_groupe_id;
			$user['user_level'] = $user_level;
			$user->save();
			return 1;
		}else{
			return -1;
		}		
	}
	
	function getUserById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0];
	}
	
	function getUserIdByEmail($email)
	{
		Doctrine_Core :: loadModels('./models');
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_email', $email ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_id'];
	}
	
	function getUserNomById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_nom'];
	}
	
	function getUserPrenomById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_prenom'];
	}
	
	function getUserNumRueById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_num_rue'];
	}
	
	function getUserLibRueById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_lib_rue'];
	}
	
	function getUserCPById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_cp'];
	}
	
	function getUserVilleById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_ville'];
	}
	
	function getUserTelephoneById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_telephone'];
	}
	
	function getUserEmailById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_email'];
	}
	
	function getUserMdpById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_mdp'];
	}
	
	function getUserLevelById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_level'];
	}
	
	function getUserGroupeIdById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
		$user = $user->getData();
		if(count($user) != 1)
			return -1;
		return $user[0]['user_groupe_id'];
	}
	
	function getUsersByIds($ids)
	{
		Doctrine_Core :: loadModels('./models');
		if(count($ids)>1){
			$listeUsers = array();
			foreach ($ids as $id){
				$user = Doctrine_Core :: getTable ( 'User' )->findBy('user_id', $id ,null);	
				$user = $user->getData();
				$listeUsers[] = $user;
			}		
			return $listeUsers;	
		}else if(count($ids) == 1){
			$user = getUserById($ids);
			return $user;
		}else{
			return -1;
		}
	}
	
	function getUsersByGroupeId($groupeId)
	{
		Doctrine_Core :: loadModels('./models');
		$listeUsers = Doctrine_Core :: getTable ( 'User' )->findBy('user_groupe', $groupeId ,null);	
		$listeUsers = $listeUsers->getData();
		if(count($listeUsers) < 1)
			return -1;
		return $listeUsers;
	}
	
	function getAllUsers()
	{
		Doctrine_Core :: loadModels('./models');
		$listeUsers = Doctrine_Core :: getTable ( 'User' )->findAll(null);	
		$listeUsers = $listeUsers->getData();
		$liste = array();
		foreach ($listeUsers as $user){
			$user = $user->getData();
			$liste[] = $user;
		}
		if(count($listeUsers) == 0)
			return -1;
		return $liste;
	}

	function setUserNomById($id, $user_nom)
	{
		Doctrine_Core :: loadModels("./models");
		$user = getUserById($id);
		if($user != -1){
			$user['user_nom'] = $user_nom;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserPrenomById($id, $user_prenom)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_prenom'] = $user_prenom;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserNumRueById($id, $user_num_rue)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_num_rue'] = $user_num_rue;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserLibRueById($id, $user_lib_rue)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_lib_rue'] = $user_lib_rue;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserCPById($id, $user_cp)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_cp'] = $user_cp;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserVilleById($id, $user_ville)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_ville'] = $user_ville;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserTelephoneById($id, $user_telephone)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_telephone'] = $user_telephone;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserEmailById($id, $user_email)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_email'] = $user_email;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserMdpById($id, $user_Mdp)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_mdp'] = $user_mdp;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserLevelById($id, $user_level)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_level'] = $user_level;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}

	function setUserGroupeIdById($id, $user_groupe_id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user['user_groupe_id'] = $user_groupe_id;
			$user->save();
			return 1;
		}else{
			return -1;
		}	
	}
	
	function deleteUserById($id)
	{
		Doctrine_Core :: loadModels('./models');
		$user = getUserById($id);
		if($user != -1){
			$user->delete();
			return 1;
		}else{
			return -1;
		}	
	}
?>