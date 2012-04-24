<?php

	require_once './controller.php';
	require_once '../connect.php';

	class UserController extends Controller
	{
	
		public function __construct()
		{
			parent::__construct();
		}
			
		private function execute_login()
		{
			$doc = new Document();
			$doc->begin(0);
			$doc->contenu_login();
			$doc->end();
		}
		
		private function execute_about()
		{
			$doc = new Document();
			if(!isset($_SESSION['level'])){
				$doc->begin(0);
				$doc->contenu_about();
			}else if($_SESSION['level'] == '1' || $_SESSION['level'] == '2'){
				$doc->begin($_SESSION['level']);
				$doc->contenu_about();
			}		
			$doc->end();
		}
		
		private function execute_contact()
		{
			$doc = new Document();
			if(!isset($_SESSION['level'])){
				$doc->begin(0);
				$doc->contenu_contact();
			}else if($_SESSION['level'] == '1' || $_SESSION['level'] == '2'){
				$doc->begin($_SESSION['level']);
				$doc->contenu_contact();
			}	
				$doc->end();
		}
			
		private function execute_erreur(){
			$doc = new Document();
			$doc->begin(0);
			//$doc->erreur_login();
			$doc->end();
		}
					
		private function execute_informations()
		{
			$doc = new Document();
			if(!isset($_SESSION['level'])){
				$doc->begin(0);
			}else if($_SESSION['level'] == '1' || $_SESSION['level'] == '2'){
				$doc->begin($_SESSION['level']);
				//$doc->informations();
				$doc->end();
			}				
		}
			
		private function execute_modification_informations()
		{
			$doc = new Document();
			if(!isset($_SESSION['level'])){
				$doc->begin(0);
			}else if($_SESSION['level']=='1' || $_SESSION['level'] == '2'){
				$doc->begin($_SESSION['level']);
				//$doc->informationsModification();
				$doc->end();
			}
	
		}
			
		private function execute_index()
		{
			$doc = new Document();
			if(!isset($_SESSION['level'])){
				$doc->begin(0);
				$doc->contenu_deconnected();
			}else{
				$doc->begin($_SESSION['level']);
				$doc->contenu_deconnected();
			}
			$doc->end();
		}
			
		private function execute_connected()
		{
			$doc = new Document();
			$doc->begin($_SESSION['level']);
			$doc->contenu_connected();
			$doc->end();
		}
			
		private function execute_user_inscription(){
			$doc = new Document();
			$doc->begin(0);
			$doc->contenu_user_inscription();
			$doc->end();
		}
		
		private function execute_logout()
		{
			session_destroy();
			$doc = new Document();
			$doc->begin(0);
			$doc->contenu_deconnected();
			$doc->end();
		}
			
		protected function execute()
		{
			$action = $this->action;
			$dest = "";
			if($action == "index"){							/* Affichage index */
				$dest = "index.php";
				$this->execute_index();
			}else if($action == "about"){
				$dest = "about.php";
				$this->execute_about();
			}else if($action == "contact"){
				$dest = "contact.php";
				$this->execute_contact();
			}else if($action == "user_inscription"){
				$dest = "user_inscription.php";
				$this->execute_user_inscription();
			}else if($action == "login"){					/* Connexion adhérent */
				if(!isset($_SESSION['prenom']) || !isset($_SESSION['level'])){			/* Si pas déjà connecté */
					$dest = "login.php";
					$this->execute_login();
				}else{																	/* Si déjà connecté */
					$dest = "index.php";
					$this->execute_index();
				}
					
			}else if($action == "connexion"){				/* Etablissement de la connexion */
				if(!isset($_SESSION['level'])){				/* Si pas connecté */
					$array = array();
					$array = user_connect();
					if($array == TRUE){						/* Connexion réussie */
						$dest = "connected.php";
						$_SESSION['id'] = $array['user_id'];
						$_SESSION['prenom'] = $array['user_prenom'];
						$_SESSION['nom'] = $array['user_nom'];
						$_SESSION['email'] = $array['user_email'];
						$_SESSION['level'] = $array['user_level'];
						$this->execute_connected();
					}else{									/* Echec connexion */
						$dest = "error.php";
						$this->execute_erreur();            /*retourne un erreur à l'utilisateur */
					}
				}else{										/* Si déjà connecté on renvoi à l'index */
					$dest = "index.php";
					$this->execute_index();
				}
			}else if($action == "logout"){					/* Déconnexion */
				session_unset();
				$dest = "index.php";
				$this->execute_logout();
			}else if($action == "inscription"){
				$dest = "inscription.php";
				$this->execute_inscription();
			}else if($action == "informations"){
				$dest = "infos.php";
				$this->execute_informations();
			}else if($action == "modification_informations"){
				$dest = "modif_infos.php";
				$this->execute_modification_informations();
			}
			if(!empty($dest))
				$this->destination = $dest;
		}
			
	}
	
	$controller = new UserController();
	$controller->process();
	
?>