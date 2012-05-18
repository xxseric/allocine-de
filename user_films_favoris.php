<?php

	session_start();
	
	require_once 'view/document.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/filmFavoris_dao.php';

	function content_user_favoris()
	{
		$listeFilms = getFilmFavorisByUserId($_SESSION['user_id']);
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
		else{
			$html = "
					<div id='content_user_favoris'>
						<h1>Vos favoris</h1>
						<center><table border=0>";
			for($i=0; $i<count($listeFilms); $i++){
				$film = getFilmById($listeFilms[$i]['film_id']);
				$html .= "	<tr>
								<td><img src='./images/".$film['film_image_id'].".jpg'></img></td>
								<td><a href='fiche_film.php?filmId=".$film['film_id']."'>".$film['film_titre']."</a></td>
								<td>
									<form id='form_favoris' method='post' action='' >
										<input type='hidden' name='' value='' />
										<button type='submit'><img src='./images/delete.png'></img></button>
									</form>
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
		$doc->begin(0);
	}else{
		$doc->begin($_SESSION['user_level']);
	}
	echo content_user_favoris();
	$doc->end();
	
?>