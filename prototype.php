<?php 

	@require_once 'rating_functions.php';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" href="./css/style.css" />
		<style type="text/css">
			@import "./js/dojo/dijit/themes/soria/soria.css";
			@import "./js/dojo/dijit/themes/tundra/tundra.css" />
			@import "./js/dojo/dojo/resources/dojo.css";
		</style>
		<script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>
		<script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>
		<!-- Star Rating widget stuff here... -->
		<script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>
		<link rel="stylesheet" type="text/css" href="css/crystal-stars.css?b38"/>
		<style type="text/css">
			#loader {display:none;padding-left:20px; background:url(images/crystal-arrows.gif) no-repeat center left;}
		</style>
		<script type="text/javascript">
			$(function(){
				$("#rat").children().not(":radio").hide();
				// Create stars
				$("#rat").stars({
					// starWidth: 28, // only needed in "split" mode
					cancelShow: false,
					callback: function(ui, type, value)
					{
						// Hide Stars while AJAX connection is active
						$("#rat").hide();
						$("#loader").show();
						// Send request to the server using POST method
						/* NOTE: 
							The same PHP script is used for the FORM submission when Javascript is not available.
							The only difference in script execution is the returned value. 
							For AJAX call we expect an JSON object to be returned. 
							The JSON object contains additional data we can use to update other elements on the page.
							To distinguish the AJAX request in PHP script, check if the $_SERVER['HTTP_X_REQUESTED_WITH'] header variable is set.
							(see: rating_functions.php)
						*/ 
						$.post("rating_functions.php", {rate: value}, function(db)
						{
							// Select stars to match "Average" value
							ui.select(Math.round(db.avg));
							// Update other text controls...
							$("#avg").text(db.avg);
							$("#votes").text(db.votes);
							// Show Stars
							$("#loader").hide();
							$("#rat").show();
						}, "json");
					}
				});
			});
		</script>
		
		<script type="text/javascript" src="./js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
	    <script type="text/javascript">
	    	dojo.require("dijit.form.ValidationTextBox");
	    	dojo.require("dijit.form.NumberTextBox");
	    	dojo.require("dijit.form.TextBox");
	    	dojo.require("dojo.parser");
	    	dojo.require("dijit.form.Form");
	    	dojo.require("dijit.form.Button");
   			dojo.require("dojox.validate.regexp");
   			dojo.require("dojox.form.PasswordValidator");
	    </script>	
		<title>Allocine</title>
	</head>

	<body>
	
		<div id="page">
		
			<div id="header">
				<h1>ALLOCINE</h1>
				<h2>A chacun son film...</h2>
				<div id="connexion" class="soria">
				</div>
				<div id="separator">
				</div>
				<div class="menu">
					<ul id="nav">
						<li><a href="">Home</a></li>
						<li><a href="">About</a></li>
						<li><a href="">Contact</a></li>
						<li><a href="">Login</a></li>
					</ul>
				</div>
			</div>
			
			<!-- CONTENU FILM -->
			<div id="contenu_film">
				<h1>Men In Black</h1>
				<div id="jaq_infos">
					<div class="jaquette">
						<img src="./images/mibI.jpg"></img>
					</div>
					<div class="informations">
						<ul>
							<li>
								<span class="bold">Annnée : </span>1997
							</li>
							<li>
								<span class="bold">Réalisé par : </span>Barry Sonnenfeld
							</li>
							<li>
								<span class="bold">Acteurs : </span>Will Smith, Tommy Lee Jones, Vincent D'Onofrio
							</li>
							<li>
								<span class="bold">Genre(s) : </span>Science fiction, Comédie
							</li>
							<li>
								<span class="bold">Nationalité(s) : </span>Américain
							</li>
							<li class="rating">
								<form id="rat" action="" method="post">
									<?php
										$inputs = "";
										foreach($options as $id => $rb){
											$inputs = $inputs.
												"<input type='radio' name='rate' value='".$id."' title='".$rb['title']."' ".$rb['checked']." ".$rb['disabled']." /></br>";
										}
										if(!$rb['disabled']){
											$inputs = $inputs."<input type='submit' value='Rate it' />";
										}
										echo $inputs; 
									?>
								</form>
								<div id="loader"><div style="padding-top: 5px;">please wait...</div></div>
								<!-- <?php// $db = get_votes() ?>
								<div>
									Item Popularity: <span id="avg"><?php //echo $db['avg'] ?></span>/<strong><?php //echo count($options) ?></strong>
									(<span id="votes"><?php// echo $db['votes'] ?></span> votes cast)
								</div> -->
							</li>
						</ul>								
					</div>
				</div>
				<div id="resume">
					<h2>Synopsis</h2>
					<p>
						Chargés de protéger la Terre de toute infraction extraterrestre et de réguler l'immigration intergalactique sur notre planète, 
						les Men in black ou MIB opèrent dans le plus grand secret. Vêtus de costumes sombres et équipés des toutes dernières technologies, 
						ils passent inaperçus aux yeux des humains dont ils effacent régulièrement la mémoire récente : la présence d'aliens sur notre sol 
						doit rester secrète. Récemment séparé de son vieux partenaire, retourné à la vie civile sans aucun souvenir de sa vie d'homme en noir, 
						K, le plus expérimenté des agents du MIB décide de former J, un jeune policier. Ensemble, ils vont afronter une nouvelle menace : 
						Edgar le cafard...
					</p>
				</div>
			</div>
			
			<!-- CONTENU DECONNECTE -- AVEC DEFILEMENT JAQUETTES FILMS -->
			<!-- <div id="contenu_deconnected">
				<div id="banniere">
					<h1>Bienvenu</h1>
				</div>
				<article>
					<section id="galerie_texte">
						<ul>
							<li><img src="./images/1.jpg"></img></li>
							<li><img src="./images/2.jpg"></img></li>
							<li><img src="./images/3.jpg"></img></li>
							<li><img src="./images/4.jpg"></img></li>
							<li><img src="./images/5.jpg"></img></li>
							<li><img src="./images/6.jpg"></img></li>
							<li><img src="./images/7.jpg"></img></li>
							<li><img src="./images/8.jpg"></img></li>
							<li><img src="./images/9.jpg"></img></li>
							<li><img src="./images/10.jpg"></img></li>
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
			</div> -->
			
			
			<!-- PROTOTYPE CONTENU CONNEXION -->
			<!-- <form method="post" action="./controller/user_controller.php?action=connexion" enctype="multipart/form-data" class="soria" id="formulaire_connexion" dojoType="dijit.form.Form">	
				<h1>Connexion</h1>
				<table border=0>
					<tr>
						<td>
							<label>Email</label>
						</td>
						<td>
							<input id="email" type="text" name="email" class="long" value=""
    											dojoType="dijit.form.ValidationTextBox"
    											regExpGen="dojox.validate.regexp.emailAddress"
    											trim="true"
    											required="true"
    											invalidMessage="Email non valide." />
						</td>
					</tr>
					<tr>
						<td>
							<label>Mot de passe</label>
						</td>
						<td>
							<input type="password"
    											id="password"
	    										name="password"
    											dojoType="dijit.form.ValidationTextBox"
    											required="true"
    											trim="true"
    											invalidMessage="Le mot de passe est nÃ©cessaire" />
    					</td>
					</tr>
				</table>
				<center><button type="submit" dojoType="dijit.form.Button" onClick="dijit.byId('formulaire_connexion').validate();">Se connecter</button></center>
			</form> -->
			
			<div id="footer">
				<p>Copyright © 2012 <a href="#">Desmauts-Evers</a></p>
				<p><a href="#">Valid XHTML 1.0 Strict</a> | <a href="#">Valid CSS</a></p>
			</div>
			
		</div>

	</body>

</html>