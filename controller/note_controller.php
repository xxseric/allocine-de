<?php

	require_once './controller.php';
	require_once '../connect.php';
	require_once './note_controller_functions.php';


	class NoteController extends Controller
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
			
			if($action == "note_film"){							/* Affichage index */
				$dest = processNotationFilm();
				echo $dest;
			}
			
			if(!empty($dest))
				$this->destination = $dest;
		}
			
	}
	
	$controller = new NoteController();
	$controller->process();
	
?>