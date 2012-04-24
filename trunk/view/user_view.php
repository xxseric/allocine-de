<?php

	class UserView
	{
		
		public static function getInscription()
		{
			$html=
<<<HEREDOC
<div id="response" ></div>
<form method="post" action="" onSubmit="inscriptionUser();return false;" name="formulaire_user_inscription" id="formulaire_user_inscription" enctype="multipart/form-data" class="soria" dojoType="dijit.form.Form">
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
								constraints="{min:0,max:1000,places:0}" invalidMessage="numéro de rue incorrect"/>
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
				<input type="text" name="user_cp" id="user_cp" data-dojo-type="dijit.form.NumberTextBox" />
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
				<input type="text" name="user_email" id="user_email" data-dojo-type="dijit.form.ValidationTextBox" regExpGen="dojox.validate.regexp.emailAddress" trim="true" invalidMessage="Email non valide." required="true" />
			</td>
		</tr>
		<tr>
			<td>
				<label>Confirmer Adresse Mail</label><span id="asterisque">*</span>
			</td>
			<td>
				<input type="text" name="user_confirm_email" id="user_confirm_email" data-dojo-type="dijit.form.ValidationTextBox" regExpGen="dojox.validate.regexp.emailAddress" trim="true" invalidMessage="Email non valide." required="true" />
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
		
		public static function getInformations()
		{
			
		}
		
	}

?>