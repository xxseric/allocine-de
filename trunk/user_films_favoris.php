<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/filmFavoris_dao.php';

	function content_user_favoris($userId)
	{
		$listeFilms = getFilmFavorisByUserId($userId);	
		if($listeFilms == null){
			$html = "
					<div id='content_user_favoris'>
						<h1>Vos favoris</h1>
						<div id='contenu_erreur'>
							<img src='./images/warning.png' style='margin: auto; width:80px; height: 66px; margin-bottom: 20px;'></img></br>
							<p>Vous n'avez pas de film favoris pour le moment.</p>
						</div>
					</div>
			";
			return $html;
		}
		else if(count($listeFilms) == 1){
			$html = "
					<div id='content_user_favoris'>
						<h1>Vos favoris</h1>
						<center><table border=0>";
			$film = getFilmById($listeFilms[0]['film_id']);
			$html .= "	<tr>
							<td><img src='./images/".$film['film_image_id'].".jpg'></img></td>
							<td><a href='fiche_film.php?filmId=".$film['film_id']."'>".$film['film_titre']."</a></td>
							<td>
								<form id='form_favoris' method='post' action='./controller/filmFavoris_controller.php?action=enlever_film_favoris' >
									<input type='hidden' name='retour' value='1' />
									<input type='hidden' name='film_id' value='".$film['film_id']."' />
									<input type='hidden' name='film_favoris_id' value='".$listeFilms[0]['film_favoris_id']."' />
									";
										if($_SESSION['user_id'] == $userId){
						$html	.=	"<button type='submit'><img src='./images/delete.png'></img></button>";
						}
						$html	.="	</form>
							</td>
						</tr>";
			$html .= "
					</table></center>
				</div>
			";
			return $html;
		}
		else{
			$html = "
					<div id='content_user_favoris'>
						<h1>Vos favoris</h1>
						<center><table border=0>";
			foreach ($listeFilms as $film){
				$f = getFilmById($film['film_id']);
				$html .= "	<tr>
								<td><img src='./images/".$f['film_image_id'].".jpg'></img></td>
								<td><a href='fiche_film.php?filmId=".$f['film_id']."'>".$f['film_titre']."</a></td>
								<td>
									<form id='form_favoris' method='post' action='./controller/filmFavoris_controller.php?action=enlever_film_favoris' >
										<input type='hidden' name='film_favoris_id' value='".$film['film_favoris_id']."' />
										";
						if($_SESSION['user_id'] == $userId){
						$html	.=	"<button type='submit'><img src='./images/delete.png'></img></button>";
						}
						$html	.="	</form>
								</td>
							</tr>";
				
			}
			$html .= "
						</table></center>
					</div>
			";
			return $html;
		}
	}	
	
	$doc = new Document();
	if(!isset($_SESSION['user_level'])){
		$doc->begin(0, "");
	}else{
		$doc->begin($_SESSION['user_level'], "");
	}
	
	if(isset($_POST['favoris_user_id'])){
	echo content_user_favoris($_POST['favoris_user_id']);
	}else{
	echo content_user_favoris($_SESSION['user_id']);
	}

	$doc->end();
	
?>