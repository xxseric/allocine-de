<?php
	
	
	class Document
	{
		
		protected $css;
		protected $siteUrl = "http://localhost/Allocine";	
		protected $user_level = 0;
		protected $user_id;
		protected $site_style = "default";
		protected $access_level = 0;
		
		public function __construct()
		{
			if(isset($_SESSION['user_level'])){
				$this->user_level = $_SESSION['user_level'];
				$this->user_id = $_SESSION['user_id'];
				$this->site_style = $_SESSION['site_style'];
			}
		}
		
		public function begin($level = 0, $en_tete)
		{
			$this->access_level = $level;
			
			$this->header_view($en_tete);
			if(!$this->menu_view()){
				$this->end();
			}
		}
			
		public function header_view($en_tete)
		{
			if($this->user_level > 0){
				$this->header_connected($en_tete);
			}else{
				$this->header_deconnected($en_tete);
			}
		}
		
		public function menu_view()
		{
			if(isset($_SESSION['level'])){
				$this->user_level = $_SESSION['level'];
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
		public function header_connected($en_tete)
		{
			$style = '<link rel="stylesheet" href="./css/'.$this->site_style.'_style.css" />';
			$html=
<<<HEREDOC

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        $style
		<style type="text/css">
			@import "./js/dojo/dijit/themes/soria/soria.css";
			@import "./js/dojo/dijit/themes/tundra/tundra.css" />
			@import "./js/dojo/dijit/themes/tundra/a11y.css" />
			@import "./js/dojo/dijit/themes/tundra/claro.css" />
			@import "./js/dojo/dijit/themes/tundra/nihilo.css" />
			@import "./js/dojo/dojo/resources/dojo.css";
			@import "./js/dojo/dojox/grid/resources/soriaGrid.css";
			@import "./js/dojo/dojox/grid/resources/Grid.css";
		</style>
		<script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>
		<script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>
		<!-- Star Rating widget stuff here... -->
		<script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>
		<link rel="stylesheet" type="text/css" href="css/crystal-stars.css?b38"/>
		<style type="text/css">
			#loader {display:none;padding-left:20px; background:url(images/crystal-arrows.gif) no-repeat center left;}
		</style>
		
		
		<script type="text/javascript" src="./js/fonctionJs.js"></script>
		<script type="text/javascript" src="./js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
	    <script type="text/javascript">
	    	dojo.require("dojo.parser");
	    	dojo.require("dijit.layout.ContentPane");
	    	dojo.require("dijit.layout.TabContainer");
	   		dojo.require("dijit.form.ValidationTextBox");
	    	dojo.require("dijit.form.NumberTextBox");
	    	dojo.require("dijit.form.DateTextBox");
	    	dojo.require("dijit.form.TextBox");
	    	dojo.require("dijit.form.Textarea");
	    	dojo.require("dijit.form.SimpleTextarea");
	    	dojo.require("dijit.form.FilteringSelect");
	    	dojo.require("dijit.form.Button");
	    	dojo.require("dijit.form.RadioButton");
	    	dojo.require("dijit.form.CheckBox");
	    	dojo.require("dijit.form.Form");
	    	dojo.require("dojox.grid.DataGrid");
	    	dojo.require("dojo.data.ItemFileReadStore");
	    	dojo.require("dojox.validate.regexp");
	    	dojo.require('dijit.Editor');
	    	dojo.require("dijit.form.Select");
	    </script>
	    
	    <script type="text/javascript" src="./js/highcharts.js"></script>
		<script type="text/javascript" src="./js/modules/exporting.js"></script>
		<script src="./js/jquery-1.7.2.min.js" type="text/javascript"></script>
		<title>Allocine</title>
		
		$en_tete
		
	</head>

	<body>
	
		<div id="page">
		
			<div id="header">
				<h1><a href="./controller/user_controller.php?action=index">ALLOCINE</a></h1>
				<h2>A chacun son film...</h2>
				<div id="connexion" class="soria">
				</div>
				<div id="separator">
				</div>
				<form method='post' action="rechercherFilm.php" name='rechercher_film' id='rechercher_film' >
					<input type="text" name="recherche" id="recherche" value="" placeholder="Rechercher un Film..."/>
					<button type="submit" id="submitButton"><center><img src="./images/loupe.png" style="height: 12px; width: 12px;"></img></center></button>
				</form>
HEREDOC;
			echo $html;
			switch($this->user_level){
				case 1: $this->header_level_1();	
				break;
				case 2: $this->header_level_2();
				break;
				case 3: $this->header_level_3();		
			}
		}

		public function header_level_1()
		{
			$html=
<<<HEREDOC
				<div class="menu">
					<ul id="nav">
						<li><a href="./controller/user_controller.php?action=film">Films</a></li>
						<li><a href="./controller/user_controller.php?action=user_gestion">Gestion</a></li>
						<li><a href="./controller/user_controller.php?action=logout">Logout</a></li>
					</ul>
					<div id="user_favoris"><a href="./controller/filmFavoris_controller.php?action=user_favoris">Vos favoris</a></div>
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
						<li><a href="./controller/user_controller.php?action=film">Films</a></li>
						<li><a href="./controller/user_controller.php?action=user_gestion">Gestion</a></li>
						<li><a href="./controller/user_controller.php?action=logout">Logout</a></li>
					</ul>
					<div id="user_favoris"><a href="./controller/filmFavoris_controller.php?action=user_favoris">Vos favoris</a></div>
				</div>
			</div>
HEREDOC;
			echo $html."<br/>";
		}	
		
		public function header_level_3()
		{
			$html=
<<<HEREDOC
				<div class="menu">
					<ul id="nav">
						<li><a href="./controller/user_controller.php?action=film">Films</a></li>
						<li><a href="./controller/user_controller.php?action=user_gestion">Gestion</a></li>
						<li><a href="./controller/user_controller.php?action=liste_users">Inscrits</a></li>
						<li><a href="./controller/user_controller.php?action=logout">Logout</a></li>
					</ul>
					<div id="user_favoris"><a href="./controller/filmFavoris_controller.php?action=user_favoris">Vos favoris</a></div>
				</div>
			</div>
HEREDOC;
			echo $html."<br/>";
		}		
		
		public function header_deconnected($en_tete)
		{
			$style = '<link rel="stylesheet" href="./css/'.$this->site_style.'_style.css" />';
			$html=
<<<HEREDOC

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	        $style
		<style type="text/css">
			@import "./js/dojo/dijit/themes/soria/soria.css";
			@import "./js/dojo/dijit/themes/tundra/tundra.css" />
			@import "./js/dojo/dijit/themes/tundra/a11y.css" />
			@import "./js/dojo/dijit/themes/tundra/claro.css" />
			@import "./js/dojo/dijit/themes/tundra/nihilo.css" />
			@import "./js/dojo/dojo/resources/dojo.css";
			@import "./js/dojo/dojox/grid/resources/soriaGrid.css";
			@import "./js/dojo/dojox/grid/resources/Grid.css";
		</style>
		<script type="text/javascript" src="js/fonctionJs.js"></script>
		<script type="text/javascript" src="js/jquery.min.js?v=1.4.2"></script>
		<script type="text/javascript" src="js/jquery-ui.custom.min.js?v=1.8"></script>
		<!-- Star Rating widget stuff here... -->
		<script type="text/javascript" src="js/jquery.ui.stars.js?v=3.0.0b38"></script>
		<link rel="stylesheet" type="text/css" href="css/crystal-stars.css?b38"/>
		<style type="text/css">
			#loader {display:none;padding-left:20px; background:url(images/crystal-arrows.gif) no-repeat center left;}
		</style>
		
		
		
		<script type="text/javascript" src="./js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
	    <script type="text/javascript">
	    	dojo.require("dojo.parser");
	    	dojo.require("dijit.layout.ContentPane");
	    	dojo.require("dijit.layout.TabContainer");
	   		dojo.require("dijit.form.ValidationTextBox");
	    	dojo.require("dijit.form.NumberTextBox");
	    	dojo.require("dijit.form.DateTextBox");
	    	dojo.require("dijit.form.TextBox");
	    	dojo.require("dijit.form.Textarea");
	    	dojo.require("dijit.form.SimpleTextarea");
	    	dojo.require("dijit.form.FilteringSelect");
	    	dojo.require("dijit.form.Button");
	    	dojo.require("dijit.form.RadioButton");
	    	dojo.require("dijit.form.CheckBox");
	    	dojo.require("dijit.form.Form");
	    	dojo.require("dojox.grid.DataGrid");
	    	dojo.require("dojo.data.ItemFileReadStore");
	    	dojo.require("dojox.validate.regexp");
	    	dojo.require('dijit.Editor');
	    	dojo.require("dijit.form.Select");
	    </script>
	    
	    <script type="text/javascript" src="./js/highcharts.js"></script>
		<script type="text/javascript" src="./js/modules/exporting.js"></script>
		
		<title>Allocine</title>
		
		$en_tete
	</head>

	<body onload="document.forms['formulaire_connexion'].elements['email'].focus();">
	
		<div id="page">
		
			<div id="header">
				<h1><a href="./controller/user_controller.php?action=index">ALLOCINE</a></h1>
				<h2>A chacun son film...</h2>
				<div id="connexion" class="soria">
				</div>
				<div id="separator">
				</div>
				<form method='post' action="rechercherFilm.php" name='rechercher_film' id='rechercher_film' >
					<input type="text" name="recherche" id="recherche" value="" placeholder="Rechercher un Film..."/>
					<button type="submit" id="submitButton"><center><img src="./images/loupe.png" style="height: 12px; width: 12px;"></img></center></button>
				</form>
				<div class="menu">
					<ul id="nav">
						<li><a href="./controller/user_controller.php?action=film">Films</a></li>
						<li><a href="./controller/user_controller.php?action=login">Login</a></li>
						
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
				<p><a href="./controller/user_controller.php?action=about">About</a> | <a href="./controller/user_controller.php?action=contact">Contact</a></p>
				<p>Tous droits r&eacute;serv&eacute;s 2012 : <a href="#">Desmauts-Evers</a></p>
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