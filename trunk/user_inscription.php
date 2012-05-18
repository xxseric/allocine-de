<?php

	session_start();
	
	require_once 'view/user_view.php';
	require_once 'view/document.php';
		
	$doc = new Document();
	$doc->begin(0, "");
	UserView::getInscription();
	$doc->end();

?>