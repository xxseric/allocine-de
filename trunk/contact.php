<?php

	session_start();
	
	require_once 'view/document.php';
		
	function contenu_contact()
	{
		$html=
<<<HEREDOC
<div id="contenu_contact">
	<div id="banniere">
		<h1>Nous contactez...</h1>
	</div>
	<article>
		<div class="rubric">Bienvenue sur l&#146;adress-book d&#146;AlloCin&eacute;. Vous trouverez ci-dessous les contacts et adresses email des diff&eacute;rents 
		d&eacute;partements d&#146;AlloCin&eacute;. N&#146;h&eacute;sitez pas &agrave; nous contacter pour toute question, suggestion, ou demande d&#146;informations 
		aupr&egrave;s des diff&eacute;rents d&eacute;partements indiqu&eacute;s ci-dessous. <br /><br />
		<ul>
			<li>
				<span class="bold">Supports, informations générales</span></br>Pour toutes informations g&eacute;n&eacute;rales relatives &agrave; 
				AlloCin&eacute;, un bug ou une suggestion, n&#146;h&eacute;sitez pas &agrave; nous &eacute;crire &agrave; 
				<a href="mailto:info@allocine.fr">info@allocine.fr</a>
			</li>
			<li>
				<span class="bold">Liens, Permissions</span></br>Si vous souhaitez mettre un lien AlloCiné sur votre site, 
				contactez-nous par email à <a href="mailto:regie@allocine.fr?subject=Liens, Permissions">regie@allocine.fr</a>
			</li>
		</ul>
		<p class="bold">Nos coordonn&eacute;es</p>
		<p class="">
			Faculté des Sciences<br />2 Boulevard Lavoisier <br />49045 ANGERS cedex 01 <br />Tel : 02 41 73 53 53 <br />Fax : 02 41 73 53 52 <br />Nous contacter : 
			<a href="mailto:info@allocine.fr?subject=Contact">Cliquez ici</a>
		</p>
		<p>
			Maxime Desmauts : Stagiaire<br />
			Pierre Evers : Stagiaire<br />
			Adrien Goëffon : Maître de stage<br />
		</p>
	</article>				
</div>
HEREDOC;
		echo $html."<br/>";
	}
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['user_level']);
	}
	contenu_contact();
	$doc->end();

?>