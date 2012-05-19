<?php

	include_once ('./orm/bootstrap.php');
	Doctrine_Core :: loadModels('./models');

	$user = Doctrine_Core::getTable ( 'User' )->findBy('user_id', $_POST['userId'] ,null);	
	$user[0]['user_groupe_id'] = $_POST['id_Groupe'] ;
	$user->save();

	echo "a rejoins le groupe.";
	
?>