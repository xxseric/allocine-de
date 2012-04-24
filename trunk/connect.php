<?php

	function database_connect()
	{
		$sql_host = "localhost";
		$sql_user = "admin";
		$sql_pass = "admin";
		$sql_db_name= "Allocine";
	
		/*******************************************************************/
		/*                   Connexion au serveur MySQL                    */
		/*******************************************************************/
		
		$connexion = null;
		
		try{
			$connexion = new PDO('mysql:host='.$sql_host.';dbname='.$sql_db_name,$sql_user,$sql_pass);		
		}
		catch(exception $e){
        	echo 'Erreur : '.$e->getMessage().'<br />';
        	echo 'N° : '.$e->getCode();		
		}
		
		return $connexion;
	}
	
	function user_connect()
	{
		$connexion = database_connect();
		
		/*******************************************************************/
		/*                Insertion de tables dans la bdd                  */
		/*******************************************************************/
		
		$user_email = htmlspecialchars($_POST['user_email']);
		$user_password = htmlspecialchars(md5($_POST['user_password']));
		
		$nbreEmail = $connexion->query("SELECT COUNT(user_email) FROM User WHERE user_email='".$user_email."';");
		
		if($nbreEmail->fetchColumn()==0){
			$connexion = null;
			return FALSE;
		}
		else{
			$req_password = $connexion->query("SELECT * FROM User WHERE user_email='".$user_email."';");
			$donnee = $req_password->fetch();
			if($user_password == $donnee['user_mdp']){
				$connexion = null;
				return $donnee;
			}
			else{
				$connexion = null;
				return FALSE;
			}
		}
	}

?>