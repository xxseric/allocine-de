<?php

	session_start();
	
	class Document
	{
		protected $css;
		protected $siteUrl ='http://localhost/Allocine';	
		protected $user_level = 0;
		protected $user_first_name = '';
		protected $user_last_name = '';
		protected $user_id;
		protected $access_level = 0;
		
		public function __construct()
		{
			if(isset($_SESSION['level'])){
				$this->user_level = $_SESSION['level'];
				$this->user_first_name = $_SESSION['prenom'];
				$this->user_last_name = $_SESSION['nom'];
				$this->user_id = $_SESSION['id'];
			}
		}
		
		public function begin($level = 0)
		{
			$this->access_level = $level;
			
			$this->header_view();
			if(!$this->menu_view()){
				$this->end();
			}
		}
			
		public function header_view()
		{
			if($this->user_level > 0){
				$this->header_connected();
			}else{
				$this->header_deconnected();
			}
		}
		
		public function menu_view()
		{
			if(isset($_SESSION['level']) && isset($_SESSION['first_name'])){
				$this->user_level = $_SESSION['level'];
				$this->user_first_name = $_SESSION['first_name'];
			}
			return ($this->user_level >= $this->access_level);
		}
		
		public function end()
		{
			$this->footer_view();
		}		
		
		/*
		 ***************************************
		 *                                     *
		 * 			AFFICHAGE DU HEADER        *
		 *                                     *
		 ***************************************
		 */		
		public function header_connected()
		{
			$html=
<<<HEREDOC
<?xml version="1.0" encoding="ISO-8859-1" ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" href="../css/style.css" />
		<style type="text/css">
			@import "../js/dojo/dijit/themes/soria/soria.css";
			@import "../js/dojo/dijit/themes/tundra/tundra.css" />
			@import "../js/dojo/dojo/resources/dojo.css";
		</style>
		<script type="text/javascript" src="../js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
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
HEREDOC;
			echo $html."<br/>";
			switch($this->user_level){
				case 1: $this->header_level_1();	
				break;
				case 2: $this->header_level_2();		
			}
		}

		public function header_level_1()
		{
			$html=
<<<HEREDOC
				<div class="menu">
					<ul id="nav">
						<li><a href="./user_controller.php?action=index">Home</a></li>
						<li><a href="">Menu_Level_1</a></li>
						<li><a href="./user_controller.php?action=about">About</a></li>
						<li><a href="./user_controller.php?action=contact">Contact</a></li>
						<li><a href="">Logout</a></li>
					</ul>
				</div>
			</div>
HEREDOC;
			echo $html."<br/>";
		}
		
		public function header_level_2()
		{
			$html=
<<<HEREDOC
				<div class="menu">
					<ul id="nav">
						<li><a href="./user_controller.php?action=index">Home</a></li>
						<li><a href="">Menu_Level_2</a></li>
						<li><a href="./user_controller.php?action=about">About</a></li>
						<li><a href="./user_controller.php?action=contact">Contact</a></li>
						<li><a href="">Logout</a></li>
					</ul>
				</div>
			</div>
HEREDOC;
			echo $html."<br/>";
		}		
		
		public function header_deconnected()
		{
			$html=
<<<HEREDOC
<?xml version="1.0" encoding="ISO-8859-1" ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" href="../css/style.css" />
		<style type="text/css">
			@import "../js/dojo/dijit/themes/soria/soria.css";
			@import "../js/dojo/dijit/themes/tundra/tundra.css" />
			@import "../js/dojo/dojo/resources/dojo.css";
		</style>
		<script type="text/javascript" src="../js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
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

	<body onload="document.forms['formulaire_connexion'].elements['email'].focus();">
	
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
						<li><a href="./user_controller.php?action=index">Home</a></li>
						<li><a href="./user_controller.php?action=user_inscription">Inscription</a></li>
						<li><a href="./user_controller.php?action=login">Login</a></li>
						<li><a href="./user_controller.php?action=about">About</a></li>
						<li><a href="./user_controller.php?action=contact">Contact</a></li>
					</ul>
				</div>
			</div>
HEREDOC;
			echo $html."<br/>";
		}		
		
		/*
		 ***************************************
		 *                                     *
		 * 		   AFFICHAGE DU CONTENU        *
		 *                                     *
		 ***************************************
		 */		
		public function contenu_connected()
		{
			$html=
<<<HEREDOC
<div id="contenu">
	<h1>CONTENU DE PAGE CONNECTE</h1>
</div>
HEREDOC;
			echo $html."<br/>";
		}
		
		public function contenu_user_inscription()
		{
			$html=
<<<HEREDOC
<form method="post" action="" name="formulaire_user_inscription" id="formulaire_user_inscription" enctype="multipart/form-data" class="soria" dojoType="dijit.form.Form">
	<h1>Inscription</h1>
	<TABLE BORDER="0">
		<tr>
			<td>				
				<label>Nom</label><span id="asterisque">*</span>
			</td>
			<td>
				<input type="text" name="user_nom" id="user_nom" data-dojo-type="dijit.form.TextBox" required="true" 
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>
		<tr>
			<td>				
				<label>Pr&eacute;nom</label><span id="asterisque">*</span>
			</td>
			<td>
			<input type="text" name="user_prenom" id="user_prenom" data-dojo-type="dijit.form.TextBox" required="true" 
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>				
		<tr>
			<td>
				<label>Num&eacute;ro de rue</label>
			</td>
			<td>
				<input type="text" name="user_num_rue" id="user_num_rue" data-dojo-type="dijit.form.NumberTextBox"
								constraints="{min:0,max:1000,places:0}" invalidMessage="numÃ©ro de rue incorrect"/>
			</td>
		</tr>
		<tr>
			<td>				
				<label>Rue</label>
			</td>
			<td>
				<input type="text"" name="user_lib_rue" id="user_lib_rue" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>	
		<tr>
			<td>
				<label>Code Postal</label>
			</td>
			<td>
				<input type="text" name="user_cp" id="user_cp" data-dojo-type="dijit.form.NumberTextBox" 
								constraints="{min:0,max:99999,places:0}" invalidMessage="code postal incorrect"/>
			</td>
		</tr>
		<tr>
			<td>				
				<label>Ville</label>
			</td>
			<td>
				<input type="text" name="user_ville" id="user_ville" data-dojo-type="dijit.form.TextBox" 
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>
		<tr>
			<td>
				<label>Telephone</label>
			</td>
			<td>
				<input type="text" name="user_tel" id="user_tel" data-dojo-type="dijit.form.NumberTextBox"
								constraints="{pattern:'0000000000',max:9999999999,places:0}"/>
			</td>
		</tr>
		<tr>
			<td>
				<label>Adresse Mail</label><span id="asterisque">*</span>
			</td>
			<td>
				<input type="text" name="user_email" id="user_email" data-dojo-type="dijit.form.ValidationTextBox" required="true" />
			</td>
		</tr>
		<tr>
			<td>
				<label>Confirmer Adresse Mail</label><span id="asterisque">*</span>
			</td>
			<td>
				<input type="text" name="user_confirm_email" id="user_confirm_email" data-dojo-type="dijit.form.ValidationTextBox" required="true" />
			</td>
		</tr>								
		<tr>
			<td>							
				<label>Mot de passe</label><span id="asterisque">*</span>					 
			</td>								
			<td>
				 <input name="user_mdp" id="user_mdp" type="password" dojoType="dijit.form.TextBox" />
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<br/>
				<br/>
				<center>
			</td>
		</tr>
		<input type="hidden"  name="user_level" id="user_level" value="1"/>
	</TABLE>
	<center><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton" >S'inscrire</button></center>
</form>	
HEREDOC;
			echo $html."<br/>";
		}
		
		public function contenu_login()
		{
			$html=
<<<HEREDOC
<form name="formulaire_connexion" method="post" action="./controller/user_controller.php?action=connexion" enctype="multipart/form-data" class="soria" id="formulaire_connexion" dojoType="dijit.form.Form">	
	<h1>Connexion</h1>
	<table border=0>
		<tr>
			<td>
				<label>Email</label>
			</td>
			<td>
				<input name="email" id="email" type="text" class="long" value=""
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
</form>
HEREDOC;
			echo $html."<br/>";
		}
		
		public function contenu_deconnected()
		{
			$html=
<<<HEREDOC
<div id="contenu_deconnected">
	<div id="banniere">
		<h1>Bienvenu</h1>
	</div>
	<article>
		<section id="galerie_texte">
			<ul>
				<li><img src="../images/1.jpg"></img></li>
				<li><img src="../images/2.jpg"></img></li>
				<li><img src="../images/3.jpg"></img></li>
				<li><img src="../images/4.jpg"></img></li>
				<li><img src="../images/5.jpg"></img></li>
				<li><img src="../images/6.jpg"></img></li>
				<li><img src="../images/7.jpg"></img></li>
				<li><img src="../images/8.jpg"></img></li>
				<li><img src="../images/9.jpg"></img></li>
				<li><img src="../images/10.jpg"></img></li>
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
		
		public function contenu_about()
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
		
		public function contenu_contact()
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
				<span class="bold">Supports, informations générales, programmes des salles</span></br>Pour toutes informations g&eacute;n&eacute;rales relatives &agrave; 
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
		
		/*
		 ***************************************
		 *                                     *
		 * 			AFFICHAGE DU FOOTER        *
		 *                                     *
		 ***************************************
		 */
		public function footer_view()
		{
			$html=
<<<HEREDOC
<div id="footer">
				<p>Copyright ï¿½ 2012 <a href="#">Desmauts-Evers</a></p>
				<p><a href="#">Valid XHTML 1.0 Strict</a> | <a href="#">Valid CSS</a></p>
			</div>
			
		</div>

	</body>

</html>
HEREDOC;
			echo $html."<br/>";
		}
	}
	
?>