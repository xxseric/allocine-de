<?php

	session_start();
	
	require_once 'controller.php';
	@require_once 'user_controller_functions.php';

	class UserController extends Controller
	{
	
		public function __construct()
		{
			parent::__construct();
		}
		
			
		private function processError(){
			$doc = new Document();
			$doc->begin(0);
			//$doc->erreur_login();
			$doc->end();
		}
					
		private function processInformations()
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
			
		private function processModificationInformations()
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
			
		protected function execute()
		{
			$action = $this->action;
			$dest = "";
			
			if($action == "index"){							/* Affichage index */
				$dest = processIndex();
			}else if($action == "about"){
				$dest = processAbout();
			}else if($action == "contact"){
				$dest = processContact();
			}else if($action == "user_inscription"){
				$dest = processInscription();
			}else if($action == "login"){					/* Connexion adhérent */
				if(!isset($_SESSION['prenom']) || !isset($_SESSION['level'])){			/* Si pas déjà connecté */
					$dest = processLogin();
				}else{																	/* Si déjà connecté */
					$dest = processIndex();
				}					
			}else if($action == "connexion"){				/* Etablissement de la connexion */
				if(!isset($_SESSION['level'])){				/* Si pas connecté */
					$dest = processConnexion();
				}else{										/* Si déjà connecté on renvoi à l'index */
					$dest = processIndex();
				}
			}else if($action == "logout"){					/* Déconnexion */
				$dest = processLogout();
			}else if($action == "informations"){
				$dest = processUserInformations();
			}else if($action == "modification_informations"){
				$dest = processUserUpdateInformations();
			}else if($action == "film"){
				$dest = processFilm();
			}
			if(!empty($dest))
				$this->destination = $dest;
		}
			
	}
	
	$controller = new UserController();
	$controller->process();
	
?>