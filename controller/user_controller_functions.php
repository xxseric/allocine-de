<?php

	function processIndex()
	{
		return "index.php";
	}	
	
	function processLogin()
	{
		return "login.php";
	}
	
	function processConnexion()
	{
		
	}
	
	function processAbout()
	{
		return "about.php";
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
	
	function processContact()
	{
		return "contact.php";
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

?>