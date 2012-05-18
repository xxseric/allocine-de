<?php

	session_start();

	require_once 'view/document.php';
	require_once 'config.php';
	
	
	function contenu_login()
	{
		$siteUrl = SITE_URL;
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
					<input name="user_email" id="user_email" type="text" class="long" value=""
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
	   									id="user_password"
	    								name="user_password"
	   									dojoType="dijit.form.ValidationTextBox"
	  									required="true"
	   									trim="true"
	   									invalidMessage="Le mot de passe est nécessaire" />
	   			</td>
			</tr>
		</table>
		<center><button type="submit" dojoType="dijit.form.Button" onClick="dijit.byId('formulaire_connexion').validate();">Se connecter</button></center>
		<center><a href="./controller/user_controller.php?action=user_inscription">Pas encore inscrit(e) ?</a></center>
	</form>
HEREDOC;
		echo $html."<br/>";
	}

	$doc = new Document();
	$doc->begin(0, "");
	contenu_login();
	$doc->end();
	
?>