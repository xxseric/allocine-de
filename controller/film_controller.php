<?php

	require_once './controller.php';
	require_once '../connect.php';
	@require_once 'film_controller_functions.php';

	class FilmController extends Controller
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
			
		protected function execute()
		{
			$action = $this->action;
			$dest = "";
			
			if($action == "fiche_film"){							/* Affichage index */
				$dest = processFicheFilm();
				$dest =  $dest."?id=".$_POST['film_id'];
			}
			
			if(!empty($dest))
				$this->destination = $dest;
		}
			
	}
	
	$controller = new FilmController();
	$controller->process();
	
?>