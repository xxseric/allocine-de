<?php
	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once 'persistence/user_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/acteur_dao.php';

	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		
		$doc->begin(0);
		echo "<div id='gestion_user'>
		<h1>Erreur d'authentification</h1>Erreur la page que vous demandez n'est pas accesible si vous n'êtes pas authentifier.
			 </div>";
	}else{
	
		$doc->begin($_SESSION['user_level']);
		$html = 
		<<<HEREDOC
<div id="contenu_recherche_film">
	<h1>Gestion</h1>

<center>
	<ul class="criteres_recherche" style="decoration:none; padding:0 ;">
		<li><div onclick="affichageGestion(0);" style="width:auto; cursor: pointer;"><img src="./images/user.png"></img>Gestion Groupe</div></li>
		<li><div onclick="affichageGestion(1);" style="width:auto; cursor: pointer;"><img src="./images/icook.png"></img>Ajouter un Film</div></li>
		<li><div onclick="affichageGestion(2);" style="width:auto; cursor: pointer;"><img src="./images/config.png"></img>Gestion du Compte</div></li>
	</ul>
</center>	
HEREDOC;
	
	////////////Parite Gestion du Groupe /////
	$html .= "<div id='gestion_groupe' style='border-top: solid black 2px ;'>";
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
				    
						foreach($groupe as $user){
							$html .= '	<tr> 
				             					<td>'.$groupe["user_nom"].'</td> 
				             				    <td>'.$groupe["user_prenom"].'</td>
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
	<div id="ajout_film" style="display:none;border-top: solid black 2px ;">
	<form method="post" action="./user_gestionUser.php" name="formulaire_ajout_film" id="formulaire_ajout_film" enctype="multipart/form-data" class="soria" dojoType="dijit.form.Form">
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
			<input type="text" name="date_film" id="date_film" data-dojo-type="dijit.form.DateTextBox" required="true"  />
			</td>
		</tr>
		<tr>
	
		</tr>				

		<tr>
			<td>				
				<label>Réalisateur</label>
			</td>
			<td>
				<input type="text"" name="realisateur_film" id="realisateur_film" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
			<td>				
				<label>Acteur</label>
			</td>
			<td>
				<input type="text"" name="acteur_film" id="acteur_film" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>	
	</TABLE> </br></br>
				
		
					<label>Image : </label>  <input type="hidden" name="MAX_FILE_SIZE" value="2097152">    
          	 		 <input type="file" name="nom_du_fichier">  </br>
          	  	</br></br>
				<label>Resumé</label>
			
				<input type="text" name="resumer_film" id="resumer_film" data-dojo-type="dijit.form.SimpleTextarea"/>
			
	<center><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton" >Ajouter</button></center>
</form> ' ;
	
///////////Gestion du compte ///////////	
	$html .= "</div>" ;
	$user = getUserById($_SESSION['user_id']);
	$html .= '<div id="gestion_compte" style="display:none;border-top: solid black 2px ;">
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
	
	//poste d'un film//
if(isset($_POST['film_titre']) && isset($_POST['film_date'])){
	
		echo '<script>affichageGestion(1);</script>';
		
		
						if(isset($_POST['realisateur_film'])){
							$resVal = explode( " " , $_POST['realisateur_film']);
							if(!(getRealisateurIdByPrenom($resVal[0]) == -1 && getRealisateurIdByNom($resVal[1]) == -1)){
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}else if (!(getRealisateurIdByNom($resVal[0]) == -1 && getRealisateurIdByPrenom($resVal[1]) == -1)){
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}else{
								addRealisateur($resVal[1],$resVal[0]);
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}
						}

						if(isset($_POST['acteur_film'])){
						$resVal = explode( " " , $_POST['acteur_film']);
						if(!(getRealisateurIdByPrenom($resVal[0]) == -1 && getRealisateurIdByNom($resVal[1]) == -1)){
							$resId = getRealisateurIdByPrenom($resVal[0]) ;
						}else if (!(getRealisateurIdByNom($resVal[0]) == -1 && getRealisateurIdByPrenom($resVal[1]) == -1)){
							$resId = getRealisateurIdByPrenom($resVal[0]) ;
						}else{
							addRealisateur($resVal[1],$resVal[0]);
							$resId = getRealisateurIdByPrenom($resVal[0]) ;
						}
					}
					
		
			if ((isset($_FILES['nom_du_fichier']['fichier'])&&($_FILES['nom_du_fichier']['error'] == UPLOAD_ERR_OK))) {    
				$chemin_destination = './images/';    
				move_uploaded_file($_FILES['nom_du_fichier']['tmp_name'], $chemin_destination.$_FILES['nom_du_fichier']['name']);    
				}   
			
	}
?>