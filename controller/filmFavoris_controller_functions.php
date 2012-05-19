<?php

	require_once '../connect.php';
	include_once ( dirname(__FILE__) . '/../orm/bootstrap.php');
	require_once ( dirname(__FILE__) . '/../persistence/filmFavoris_dao.php');
	

	function processAjouterFilmFavoris()
	{
		if(isset($_POST['film_id']) && isset($_POST['user_id'])){
			$ajout = addFavoris($_POST['film_id'], $_POST['user_id']);
		}
		return "fiche_film.php?filmId=".$_POST['film_id'];
	}	
	
	function processEnleverFilmFavoris()
	{
		if(isset($_POST['film_favoris_id'])){
			$delete = deleteFilmFavorisById($_POST['film_favoris_id']);
		}
		if(isset($_POST['film_id']))
			return "fiche_film.php?filmId=".$_POST['film_id'];
		else 
			return "rechercher_film.php";
	}
	
	function processUserFavorisListe()
	{
		return "user_films_favoris.php";
	}
	
?>