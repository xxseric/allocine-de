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
			<p class="bold_title">Bonjour, et bienvenue sur AlloCin� !</p>
			<p>Gr�ce � Allocine, vous pourrez trouver toutes les informations disponible sur un film donn� ainsi que voter vos films pr�f�r�s gr�ce � une immense base de donn�es
				regroupant tous les styles de films possible et inimaginable. Un support quotidien et rapide vous garantira enti�re satisfaction de notre site.
			</p>
			<p>
				Ce site � �t� cr�er durant deux mois de l'ann�e 2012 par deux �tudiants en licence informatique issus de la facult� des Sciences d'Angers dans le cadre d'un stage encadr� par un ma�tre
				de conf�rence du m�me �tablissement. Les auteurs vous en remercie de votre visite.
			</p>
			<p>
				Si vous avez des doutes, des questions ou si vous remarquez des bugs sur le site, n'h�sitez pas � nous contacter. Dans ce cas rendez-vous dans la rubrique contact.
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