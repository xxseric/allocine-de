<?php

	session_start();
	
	
	require_once 'view/document.php';
	include_once 'persistence/user_dao.php';
		
	function contenu_liste_users()
	{
		$html =
"<script type='text/javascript'>
		function changeUserLevel(nForm)
		{
			n = nForm.name;
			document.forms[nForm.name].submit();
		}
</script>
<div id='contenu_liste_users'>
	<h1>Liste des utilisateurs</h1>
	<div id='liste_users'>
		<table border=0>
	       	<thead>
	          	<tr>
		        	<th class='en_tete' style='width:100px; text-align:center;'>Nom</th>
		          	<th class='en_tete' style='width:100px; text-align:center;'>Prenom</th> 
		      		<th class='en_tete' style='width:150px; text-align:center;'>Email</th> 
		       		<th class='en_tete' style='width:50px; text-align:center;'>Level</th>
		       		<th></th>
		     	</tr> 
			</thead>
			<tbody>";
			$listeUsers = getAllUsers();
			$i = 1;
			foreach ($listeUsers as $user){
				$html .=
				"<tr>
					<td>".$user['user_nom']."</td>
					<td>".$user['user_prenom']."</td>
					<td>".$user['user_email']."</td>
					<td>
						<form id='level_change_".$i."' name='level_change_".$i."' method='post' action='update_user_level.php'>
						 	<select  name='user_level' onchange='changeUserLevel(this.form);'>";
								for($j=0; $j<3; $j++){
									if($j+1 == $user['user_level']){
										$html .= "<option selected value='".($j+1)."'>".($j+1)."</option>";
									}else{
										$html .= "<option value='".($j+1)."'>".($j+1)."</option>";
									}
								}
						  	$html .=
						  	"</select>
						   	<input type='hidden' name='user_id' value='".$user['user_id']."'></input>
						</form>
					</td>
					<td class='delete'>
						<form name='user_delete_".$i."' method='post' action='liste_users.php'  onsubmit=\" return confirm('Etes-vous s&ucirc;r de supprimer cet utilisateur ?'); \">
							<input type='hidden' name='user_id' value='".$user['user_id']."' />
							<input type='hidden' name='delete' value='1' />
							<button type='submit'><img src='./images/delete.png'></img></button>
						</form>
					</td>
				</tr>";
				$i++;
			}
		    $html .=  	
			"</tbody>
		</table>
	</div>
</div>";			
		    return $html;
	}

	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], "");
	}
	
	if(isset($_POST['delete']) && isset($_POST['user_id'])){
		try{
			deleteUserById($_POST['user_id']);
		}catch(Exception $e){
			
		}
	}
	echo contenu_liste_users();
	$doc->end();


?>