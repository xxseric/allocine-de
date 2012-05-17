<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/filmFavoris_dao.php';

	function content_user_favoris()
	{
		
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['user_level']);
	}
	echo content_user_favoris();
	$doc->end();
	
?>