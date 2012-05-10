<?php



	include_once ('./orm/bootstrap.php');
	Doctrine_Core :: loadModels('./models');

	$groupe = new Groupe();
	$groupe['groupe_lib'] = $_POST['nomGroupe'];
	$groupe->save();
	
	
	$user = Doctrine_Core::getTable ( 'User' )->findBy('user_id', $_POST['userId'] ,null);	
	$user[0]['user_groupe_id'] = $groupe['groupe_id'] ;
	$user->save();

	echo "Groupe creer.";
?>