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
		<li><div onclick="" style="width:auto; cursor: pointer;">Gestion Groupe</div></li>
		<li><div onclick="" style="width:auto; cursor: pointer;">Ajouter un Film</div></li>
		<li><div onclick="" style="width:auto; cursor: pointer;">Gestion du Compte</div></li>
	</ul>
	
HEREDOC;
	 $html ;
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
					echo $html ;	
					}
		$html .= "</div>";			
	//////FIn Gestion du Groupe///////////
	//ajout d'un film///////
	$html .= "<div id='ajout_film'>";
	$doc->end();
?>