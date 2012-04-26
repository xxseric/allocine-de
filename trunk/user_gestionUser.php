<?php
	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once 'persistence/user_dao.php';
	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		echo "pas ok" ;
		$doc->begin(0);
		echo "<div id='gestion_user'>
		<h1>Erreur d'authentification</h1>Erreur la page que vous demandez n'est pas accesible si vous n'êtes pas authentifier.
			 </div>";
	}else{
		echo "ok" ;
		$doc->begin($_SESSION['user_level']);
		$html = 
		<<<HEREDOC
<div id="contenu_recherche_film">
	<h1>Gestion</h1>


	<ul class="criteres_recherche" style="decoration:none;border-bottom: solid black 2px ;">
		<li><div onclick="affichageGestion(0);" style="width:auto; cursor: pointer;">Gestion Groupe</div></li>
		<li><div onclick="affichageGestion(1);" style="width:auto; cursor: pointer;">Ajouter un Film</div></li>
		<li><div onclick="affichageGestion(2);" style="width:auto; cursor: pointer;">Gestion du Compte</div></li>
	</ul>
	
HEREDOC;
	
	////////////Parite Gestion du Groupe /////
	$html .= "<div id='gestion_groupe'>";
					if($_SESSION['user_groupe_id'] != NULL){
						$html .= "				<div id='liste_users'>
									<table border=0>
				                    	<thead>
				                    		<tr>
				        	    				<th style='width:100px; text-align:center;'>Nom</th>
				             					<th style='width:100px; text-align:center;'>Prenom</th> 
				             				</tr> 
				             			</thead>
				             			<tbody>" ; 
					$groupe = getUsersByGroupeId($_SESSION['user_groupe_id']);
						for($i=0 ; $i < count($groupe) ; $i++){
							$html .= '	<tr>
				             					<td>'.$groupe[$i]["user_nom"].'</td>
				             					<td>'.$groupe[$i]["user_prenom"].'</td>
				             			</tr>';
						}
					$html .= ' 				</tbody>
									</table>
								</div>';	
					}else{
						
						$html .= "Voirs les groupes , creer un groupe";
				
				          	}
					
					
		$html .= "</div>";			
	//////FIn Gestion du Groupe///////////
	//ajout d'un film///////
	$html .= 
	'
	<div id="ajout_film" style="display:none;">
	<form method="post" action="" name="formulaire_ajout_film" id="formulaire_ajout_film" enctype="multipart/form-data" class="soria" dojoType="dijit.form.Form">
	<h3>Ajouter un film</h3>
	<TABLE BORDER="0">
		<tr>
			<td>				
				<label>Titre</label><span id="asterisque">*</span>
			</td>
			<td>
				<input type="text" name="film_titre" id="film_titre" data-dojo-type="dijit.form.TextBox" required="true" 
								data-dojo-props="trim:true, propercase:true" />
			</td>
					<td>				
				<label>Date</label><span id="asterisque">*</span>
			</td>
			<td>
			<input type="text" name="user_prenom" id="user_prenom" data-dojo-type="dijit.form.DateTextBox" required="true"  />
			</td>
		</tr>
		<tr>
	
		</tr>				

		<tr>
			<td>				
				<label>Réalisateur</label>
			</td>
			<td>
				<input type="text"" name="user_lib_rue" id="user_lib_rue" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>	
	</TABLE>
		
				<label>Resumé</label>
			
				<input type="text" name="user_num_rue" id="user_num_rue" data-dojo-type="dijit.form.SimpleTextarea"/>
			
	<center><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton" >Ajouter</button></center>
</form> ' ;
	
///////////Gestion du compte ///////////	
	$html .= "</div>" ;
	$user = getUserById($_SESSION['user_id']);
	$html .= '<div id="gestion_compte" style="display:none;">
						<TABLE id="gestion_tab" BORDER="0" cellspacing="10">
		<tr>
			<td>				
				<label><b>Nom :</b></label>
			</td>
			<td>
				'.$user['user_nom'].'
			</td>
			<td>				
				<label><b>Prenom :</b></label>
			</td>
			<td>
			'.$user['user_prenom'].'
			</td>
		</tr>
		
		<tr>
			<td>				
				<label><b>Adresse email :</b> </label>
			</td>
			<td>
			'.$user['user_email'].'	
			</td>
			<td>				
				<label><b>Numéro de rue : </b></label>
			</td>
			<td>
				'.$user['user_num_rue'].'
			</td>
		</tr>	
		<tr></tr>
		<tr>
			<td>				
				<label><b>Nom de la rue : </b></label>
			</td>
			<td>
				'.$user['user_lib_rue'].'
			</td>
			<td>				
				<label><b>Code Postal :</b></label>
			</td>
			<td>
				'.$user['user_cp'].'
			</td>
		</tr>	
		<tr></tr>	
			<tr>
			<td>				
				<label><b>Ville :</b></label>
			</td>
			<td>
				'.$user['user_ville'].'
			</td>
			<td>				
				<label><b>Téléphone :</b></label>
			</td>
			<td>
				'.$user['user_telephone'].'
			</td>
		</tr>	
	</TABLE>
</div>
</div>';
	
	echo $html ;
}
	$doc->end();
?>