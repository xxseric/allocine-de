<?php
	
	
	class Document
	{
		
		protected $css;
		protected $siteUrl = "http://localhost/Allocine";	
		protected $user_level = 0;
		protected $user_id;
		protected $access_level = 0;
		
		public function __construct()
		{
			if(isset($_SESSION['user_level'])){
				$this->user_level = $_SESSION['user_level'];
				$this->user_id = $_SESSION['user_id'];
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
		public function header_connected()
		{
			$html=
<<<HEREDOC
<?xml version="1.0" encoding="ISO-8859-1" ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">


<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
        <link rel="stylesheet" href="./css/style.css" />
        <script type="text/javascript" src="./js/fonctionJs.js" ></script>
        
		<style type="text/css">
			@import "./js/dojo/dijit/themes/soria/soria.css";
			@import "./js/dojo/dijit/themes/tundra/tundra.css" />
			@import "./js/dojo/dojo/resources/dojo.css";
		</style>
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
						<li><a href="./controller/user_controller.php?action=index">Home</a></li>
						<li><a href="">Menu_Level_1</a></li>
						<li><a href="./controller/user_controller.php?action=about">About</a></li>
						<li><a href="./controller/user_controller.php?action=contact">Contact</a></li>
						<li><a href="./controller/user_controller.php?action=logout">Logout</a></li>
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
						<li><a href="./controller/user_controller.php?action=index">Home</a></li>
						<li><a href="">Menu_Level_2</a></li>
						<li><a href="./controller/user_controller.php?action=about">About</a></li>
						<li><a href="./controller/user_controller.php?action=contact">Contact</a></li>
						<li><a href="./controller/user_controller.php?action=logout">Logout</a></li>
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
        <link rel="stylesheet" href="./css/style.css" />
        <script type="text/javascript" src="./js/fonctionJs.js" ></script>
		<style type="text/css">
			@import "./js/dojo/dijit/themes/soria/soria.css";
			@import "./js/dojo/dijit/themes/tundra/tundra.css" />
			@import "./js/dojo/dojo/resources/dojo.css";
		</style>
		<script type="text/javascript" src="./js/dojo/dojo/dojo.js" djConfig="parseOnLoad:true"></script>
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

	<body onload="document.forms['formulaire_connexion'].elements['email'].focus();">
	
		<div id="page">
		
			<div id="header">
				<h1>ALLOCINE</h1>
				<h2>A chacun son film...</h2>
				<div id="connexion" class="soria">
				</div>
				<div id="separator">
				<form method='post' onsubmit='alert("rechercher");return false;' >
				<input style="height: 25px;margin-left: 350px;margin-top: 12px;" type="text" id="recherche" value="" placeholder="Rechercher un Film..."/>
				</form>
				</div>
				<div class="menu">
					<ul id="nav">
						<li><a href="./controller/user_controller.php?action=index">Home</a></li>
						<li><a href="./controller/user_controller.php?action=user_inscription">Inscription</a></li>
						<li><a href="./controller/user_controller.php?action=login">Login</a></li>
						<li><a href="./controller/user_controller.php?action=about">About</a></li>
						<li><a href="./controller/user_controller.php?action=contact">Contact</a></li>
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
				<p>Copyright � 2012 <a href="#">Desmauts-Evers</a></p>
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