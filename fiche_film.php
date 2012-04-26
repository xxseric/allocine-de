<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
		
	function contenu_fiche_film()
	{
		$film = getFilmById($_POST['film_id']);
		if($film == -1)
			return "Un probleme est survenu";
		
		$html=
"<div id='contenu_film'>
	<h1>".$film['film_titre']."</h1>
	<div id='jaq_infos'>
		<div class='jaquette'>
			<img src='./images/mibI.jpg'></img>
		</div>
		<div class='informations'>
			<ul>
				<li>
					<span class='bold'>Annn�e : </span>1997
				</li>
				<li>
					<span class='bold'>R�alis� par : </span>Barry Sonnenfeld
				</li>
				<li>
					<span class='bold'>Acteurs : </span>Will Smith, Tommy Lee Jones, Vincent D'Onofrio
				</li>
				<li>
					<span class='bold'>Genre(s) : </span>Science fiction, Com�die
				</li>
				<li>
					<span class='bold'>Nationalit�(s) : </span>Am�ricain
				</li>
			</ul>								
		</div>
	</div>
	<div id='resume'>
		<h2>Synopsis</h2>
		<p>
			Charg�s de prot�ger la Terre de toute infraction extraterrestre et de r�guler l'immigration intergalactique sur notre plan�te, 
			les Men in black ou MIB op�rent dans le plus grand secret. V�tus de costumes sombres et �quip�s des toutes derni�res technologies, 
			ils passent inaper�us aux yeux des humains dont ils effacent r�guli�rement la m�moire r�cente : la pr�sence d'aliens sur notre sol 
			doit rester secr�te. R�cemment s�par� de son vieux partenaire, retourn� � la vie civile sans aucun souvenir de sa vie d'homme en noir, 
			K, le plus exp�riment� des agents du MIB d�cide de former J, un jeune policier. Ensemble, ils vont afronter une nouvelle menace : 
			Edgar le cafard...
		</p>
	</div>
</div>";
		return $html;
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['level'])){
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['level']);
	}
	echo contenu_fiche_film();
	$doc->end();

?>