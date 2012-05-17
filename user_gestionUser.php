<?php
	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once 'persistence/user_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/categorieFilm_dao.php';
	require_once 'persistence/groupe_dao.php';
	require_once 'persistence/filmFavoris_dao.php';
	include_once 'ajout_film.php';
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		
		$doc->begin(0);
		echo "<div id='gestion_user'>
		<h1>Erreur d'authentification</h1>Erreur la page que vous demandez n'est pas accesible si vous n'êtes pas authentifier.
			 </div>";
	}else{
		
	$ajout_film = '';
	if(isset($_SESSION['user_level']) && $_SESSION['user_level'] > 1){
		$ajout_film = '<li><div onclick="affichageGestion(1);" style="width:auto; cursor: pointer;"><img src="./images/icook.png"></img>Ajouter un Film</div></li>';
	}
	
		$doc->begin($_SESSION['user_level']);
		$html = 
<<<HEREDOC
<div id="contenu_recherche_film" class="soria">
	<h1>Gestion</h1>

<center>
	<ul class="criteres_recherche" style="decoration:none; padding:0 ;">
		<li><div onclick="affichageGestion(0);" style="width:auto; cursor: pointer; "><img src="./images/user.png"></img>Gestion Groupe</div></li>
		$ajout_film
		<li><div onclick="affichageGestion(2);" style="width:auto; cursor: pointer;"><img src="./images/config.png"></img>Gestion du Compte</div></li>
	</ul>
</center>	
HEREDOC;
	
	////////////Partie Gestion du Groupe /////
	$html .= "<div id='gestion_groupe' style='border-top: solid black 2px ;'>";
			$groupeId = getUserGroupeIdById($_SESSION['user_id']);		
			//si l'utilisateur est dans un groupe
			if($groupeId != NULL){
						$html .= "				<div id='liste_users'>
									<table border=0>
				                    	<thead>
				                    		<tr>
				        	    				<th style='width:100px; text-align:center;'>Nom</th>
				             					<th style='width:100px; text-align:center;'>Prenom</th> 
				             				</tr> 
				             			</thead>
				             			<tbody>" ; 
						
				    	$groupe = getUsersByGroupeId($groupeId);
				    	$html .= "<div style='float:right;'><button  onclick='quitterGroupe(".$_SESSION['user_id'].");'>quitter le groupe</button></div>" ;
						foreach($groupe as $user){
							$html .= '	<tr> 
				             					<td>'.$user["user_nom"].'</td> 
				             				    <td>'.$user["user_prenom"].'</td>' ;
				             				    if(is_object(getFilmFavorisByUserId($user['user_id']))){
				             				    $html.=	'<td><form action="./rechercherFilm.php" method="post">
				             				    <input type=hidden value="'.$user['user_id'].'" name="favoris_user_id" />
				             				    <input type=submit value="Voir ses favoris" />
				             				    </form></td>' ;
				             				    }else{
				             				    $html .= '<td>Pas encore de favoris</td>'	;
				             				    }
				             				   $html .= '
				             			</tr>';
						}
					$html .= ' 				</tbody>
									</table>
								</div>';	
					}else{
						//recuperer les groupe
						$allGroupe = getAllGroupe();
						$html .= "	<table border=0>
				                    	
				                    		<tr>
				        	    				<th style='width:100px; text-align:center;'><button onclick='affichageGroupe(0);'>Creer un groupe</button></th>
				             					<th style='width:100px; text-align:center;'><button onclick='affichageGroupe(1);'>Voir les groupe</button></th> 
				             				</tr> 
				             			
				             			<tbody>
				             				</tbody>
									</table>
				             			<br/>
				             			<div id='creer_groupe' >
				             			<label>Nom du groupe : </label><input type='text' id='name_groupe' name='name_groupe' />
				             			<button onclick='creerGroupe(".$_SESSION['user_id'].");' >Valider</button>
				             			</div>
				             			
				             			<div id='rejoindre_groupe' style='display:none'>
				             			";
							if($allGroupe != null){
								$html .= "<table border=0>
										<thead style='border-bottom : solid black 2px ;' >
				                    		<tr >
				        	    				<th style='width:200px;'>Nom du groupe</th>
				             					<th style='width:200px;'>Rejoindre</th> 
				             				</tr> 
				             			</thead>
				             			<tbody>
				                    	" ;
								if(count($allGroupe) == 1){
									$html .= "<tr><th>"
									.$allGroupe['groupe_lib']."</th>
										<th><button onclick='rejoindreGroupe(".$_SESSION['user_id'].",".$allGroupe['groupe_id'].")'>Rejoindre</button></th>
									</tr>" ;
								}else if(count($allGroupe) > 1){
									foreach($allGroupe as $groupe){
										$html .= "<tr><th>"
										.$groupe['groupe_lib']."</th>
										<th><button onclick='rejoindreGroupe(".$_SESSION['user_id'].",".$groupe['groupe_id'].")'>Rejoindre</button></th>
										</tr>" ;
									}
								}	
								
								$html .= "</tbody></table>";
							}else {
								$html .= "Pas de groupe creer pour le moment." ;
							}
							$html .= "  </div>";							    
				          	}
					
					
		$html .= "</div>";			
	//////Fin Gestion du Groupe///////////
	
	//ajout d'un film///////
	$html .= 
	'
	<div id="ajout_film" class="soria" style="display:none;border-top: solid black 2px ;">
	<form method="post" action="./controller/film_controller.php?action=ajout_film_brut" name="formulaire_ajout_film" id="formulaire_ajout_film" enctype="multipart/form-data" dojoType="dijit.form.Form">
	<h3>Ajouter un film</h3>
	<center><TABLE BORDER="0">
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
				<input placeholder="Nom Prenom" type="text"" name="realisateur_film" id="realisateur_film" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
			<td>
			<label>Catégorie</label>
			</td>
			<td> ';

	$listeCat = getAllCategories();
	
	if($listeCat != null){
		if(count($listeCat) > 1){
			foreach($listeCat as $categorie){
				$html	.= '<input type="checkbox" name="categorie'.$categorie['catFilm_id'].'" value="'.$categorie['catFilm_id'].'">'.$categorie['catFilm_libelle'].'<br>';
			}
		}
	}else if(count($listeCat) == 1){
		$html	.= '<input type="checkbox" name="categorie'.$listeCat['catFilm_id'].'" value="'.$listeCat['catFilm_id'].'">'.$listeCat['catFilm_libelle'].'<br>';
	}

      $html .= '	</td>
		</tr>	
		<tr>
						<td>				
				<label>Acteur</label>
			</td>
			<td>
				<input placeholder="Nom Prenom" type="text"" name="acteur_film" id="acteur_film" data-dojo-type="dijit.form.TextBox"
								data-dojo-props="trim:true, propercase:true" />
			</td>
		</tr>	
	</TABLE></center> </br></br>
				
		
					<label>Image : </label>  <input type="hidden" name="MAX_FILE_SIZE" value="2097152">    
          	 		 <input type="file" name="nom_du_fichier">  </br>
          	  	</br></br>
				<label>Resumé</label>
			
				<input type="text" name="resumer_film" id="resumer_film" data-dojo-type="dijit.form.SimpleTextarea" style="max-width: 690px;" />
			
	<center><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton" >Ajouter</button></center>
</form> 
<center><p>------------------------------ OU ------------------------------</p></center>
<h3>Importer un film via l\'id</h3>
<form method="post" action="./controller/film_controller.php?action=ajout_film_via_id" name="formulaire_import_film_via_id" id="formulaire_import_film_via_id"  enctype="multipart/form-data" dojoType="dijit.form.Form">
	<center><table border=0>
		<tr>
			<td><label>Site d\'import : </label></td>
			<td>
				<select name="site_lib" data-dojo-type="dijit.form.Select">
					<option value="allo">Allocine</option>
					<option value="imdb">Imdb</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Film id : </label></td>
			<td><input type="text" name="film_id" placeholder="Rentrez un id valide" data-dojo-type="dijit.form.TextBox" required="true"  /></td>
		</tr>
		<tr> 
			<td align="center" colspan="2"><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton2" >Ajouter</button></td>
		</tr>
	</table></center>	
</form>
<center><p>------------------------------ OU ------------------------------</p></center>
<h3>Importer un film via le titre</h3>
<form method="post" action="" name="formulaire_import_film_via_titre" id="formulaire_import_film_via_titre"  enctype="multipart/form-data" dojoType="dijit.form.Form">
	<center><table border=0>
		<tr>
			<td><label>Site d\'import : </label></td>
			<td>
				<select name="site_lib" data-dojo-type="dijit.form.Select">
					<option value="allo">Allocine</option>
					<option value="imdb">Imdb</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><label>Titre du film : </label></td>
			<td><input type="text" name="film_id" placeholder="Rentrez un titre valide" data-dojo-type="dijit.form.TextBox" required="true"  /></td>
		</tr>
		<tr> 
			<td align="center" colspan="2"><button type="submit" data-dojo-type="dijit.form.Button" id="submitButton3" >Ajouter</button></td>
		</tr>
	</table></center>	
</form>';
	
///////////Gestion du compte ///////////	
	$html .= "</div>" ;
	$user = getUserById($_SESSION['user_id']);
	$html .= '<div id="gestion_compte" style="display:none;border-top: solid black 2px ;">
						<center><TABLE id="gestion_tab" BORDER="0" cellspacing="10">
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
	</TABLE></center>
</div>
</div>';
	
	echo $html ;
}
	$doc->end();

?>