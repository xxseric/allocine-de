<?php

	require_once '../connect.php';
	include_once ( dirname(__FILE__) . '/../orm/bootstrap.php');
	require_once ( dirname(__FILE__) . '/../persistence/filmFavoris_dao.php');
	

	function processAjouterFilmFavoris()
	{
		if(isset($_POST['film_id']) && isset($_POST['user_id'])){
			$ajout = addFavoris($_POST['film_id'], $_POST['user_id']);
		}
		return "rechercherFilm.php";
	}	
	
	function processEnleverFilmFavoris()
	{
		if(isset($_POST['film_favoris_id'])){
			$delete = deleteFilmFavorisById($_POST['film_favoris_id']);
		}
		return "rechercherFilm.php";
	}
	
	function processUserFavorisListe()
	{
		return "user_films_favoris.php";
	}
	
?>