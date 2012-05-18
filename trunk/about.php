<?php

	session_start();
	
	require_once 'view/document.php';
		
	function contenu_about()
	{
		$html=
<<<HEREDOC
	<div id="contenu_about">
		<div id="banniere">
			<h1>A propos...</h1>
		</div>
		<article>
			<p class="bold_title">Bonjour, et bienvenue sur AlloCiné !</p>
			<p>Grâce à Allocine, vous pourrez trouver toutes les informations disponible sur un film donné ainsi que voter vos films préférés grâce à une immense base de données
				regroupant tous les styles de films possible et inimaginable. Un support quotidien et rapide vous garantira entière satisfaction de notre site.
			</p>
			<p>
				Ce site à été créer durant deux mois de l'année 2012 par deux étudiants en licence informatique issus de la faculté des Sciences d'Angers dans le cadre d'un stage encadré par un maître
				de conférence du même établissement. Les auteurs vous en remercie de votre visite.
			</p>
			<p>
				Si vous avez des doutes, des questions ou si vous remarquez des bugs sur le site, n'hésitez pas à nous contacter. Dans ce cas rendez-vous dans la rubrique contact.
			</p>
		</article>				
	</div>
HEREDOC;
		echo $html."<br/>";
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], "");
	}
	contenu_about();
	$doc->end();

?>