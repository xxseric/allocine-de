<?php

	include_once ('./orm/bootstrap.php');
	Doctrine_Core :: loadModels('./models');

	$user = new User();
	$user['user_nom'] = $_POST['nom'];
	$user['user_prenom'] = $_POST['prenom'];
	$user['user_num_rue'] =  $_POST['num_rue'];
	$user['user_lib_rue'] =  $_POST['libelle_rue'];
	$user['user_cp'] =  $_POST['code_postal'] ;
	$user['user_ville'] =  $_POST['ville'] ;
	$user['user_telephone'] =  $_POST['telephone'] ;
	$user['user_email'] =  $_POST['mail'] ;
	$user['user_level'] =  1 ;
	$user['user_mdp'] = md5($_POST['mot_de_passe']) ;
	
	
	$user->save();
	
	echo "Vous êtes maintenant inscris.</br></br>"
?>