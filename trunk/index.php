<?php
	
	session_start();
	
	require_once 'view/document.php';
	require_once 'config.php';
	
	function contenu_deconnected()
	{
		$siteUrl = SITE_URL;
		$html=
<<<HEREDOC
				<div id="contenu_deconnected">
					<div id="banniere">
						<h1>Bienvenu</h1>
					</div>
					<article>
						<section id="galerie_texte">
							<ul>
								<li><img src="$siteUrl/images/1.jpg"></img></li>
								<li><img src="$siteUrl/images/2.jpg"></img></li>
								<li><img src="$siteUrl/images/3.jpg"></img></li>
								<li><img src="$siteUrl/images/4.jpg"></img></li>
								<li><img src="$siteUrl/images/5.jpg"></img></li>
								<li><img src="$siteUrl/images/6.jpg"></img></li>
								<li><img src="$siteUrl/images/7.jpg"></img></li>
								<li><img src="$siteUrl/images/8.jpg"></img></li>
								<li><img src="$siteUrl/images/9.jpg"></img></li>
								<li><img src="$siteUrl/images/10.jpg"></img></li>
							</ul>
						</section>
						<p>Allocine, un site regroupant une immense base donnees de films</p>
						<p>Sur ce site vous pouvez :</p>
						<ul>
							<li>Consulter le contexte d'un film</li>
							<li>Donner votre avis sur un film</li>
							<li>Modifier les informations d'un film</li>
						</ul>
					</article>				
				</div>
HEREDOC;
				echo $html."<br/>";
			}
		
	$doc = new Document();
	if(!isset($_SESSION['level'])){
		$doc->begin(0);
	}
	else{
		$doc->begin($_SESSION['level']);
	}
	contenu_deconnected();
	$doc->end();

?>