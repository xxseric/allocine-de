<?php

	require_once './controller.php';
	require_once './filmFavoris_controller_functions.php';

	class FilmFavorisController extends Controller
	{
	
		public function __construct()
		{
			parent::__construct();
		}
			
		protected function execute()
		{
			$action = $this->action;
			$dest = "";
			
			if($action == "ajouter_film_favoris"){							/* Affichage index */
				$dest = processAjouterFilmFavoris();
			}else if($action == "enlever_film_favoris"){							/* Affichage index */
				$dest = processEnleverFilmFavoris();
			}else if($action == "user_favoris"){
				$dest = processUserFavorisListe();
			}
			
			if(!empty($dest))
				$this->destination = $dest;
		}
			
	}
	
	$controller = new FilmFavorisController();
	$controller->process();
	
?>