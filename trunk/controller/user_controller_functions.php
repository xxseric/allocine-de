<?php

	require_once '../connect.php';
	

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
			$_SESSION['user_groupe_id'] = $array['user_groupe_id'];
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
	
	function processListeUsers()
	{
	echo "test";
		return "liste_users.php";
	}
	
	function processUserGestion(){
		return "user_gestionUser.php";
	}
?>