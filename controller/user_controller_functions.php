<?php

	require_once '../connect.php';
	require_once './persistence/user_dao.php';

	function processIndex()
	{
		return "index.php";
	}	
	
	function processInscription()
	{
		return "user_inscription.php";
	}
	
	function processLogin()
	{
		return "login.php";
	}
	
	function processConnexion()
	{
		$array = array();
		$array = user_connect();
		if($array == TRUE){								/* Connexion reussie */
			$_SESSION['user_id'] = $array['user_id'];
			$_SESSION['user_level'] = $array['user_level'];
		}else{											/* Echec connexion */
			return "login.php";		          			/* Retourne une erreur a� l'utilisateur */
		}
		return "index.php";
	}
	
	function processAbout()
	{
		return "about.php";
	}
	
	function processContact()
	{
		return "contact.php";
	}
	
	function processLogout()
	{
		unset($_SESSION['user_id']);
		unset($_SESSION['user_level']);
		return "index.php";
	}

	function processFilm(){
		return "rechercherFilm.php";
	}
	
	function processChangeLevel(){
		setUserLevelById($_POST['user_id'], $_POST['user_level']);
		return "prototype.php";
	}
?>