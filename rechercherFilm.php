<?php

	session_start();
	
	//require_once 'view/user_view.php';
	require_once 'view/document.php';
	require_once './orm/film_dao.php';	
	require_once './orm/realisateur_dao.php';
	
	$doc = new Document();
	$doc->begin(0);
							$html=
<<<HEREDOC
<div id="film">
<h1>Liste des Films</h1>
<h2>Trier par :</h2> 
<p>
<div onclick="document.getElementById('categorie').style.display = 'block';" style="width:auto; cursor: pointer;float:left;">-categories</div>
<div onclick="document.getElementById('categorie').style.display = 'block';" style="width:auto; cursor: pointer;margin-left:150px;">-Recherche Avancer</div><br>
<div onclick="document.getElementById('categorie').style.display = 'block';" style="width:auto; cursor: pointer;">-Note</div>


</p>

<div id="categorie" style="display:none;">
<a>-Action </a><br>
<a>-Dramatique </a><br>
<a>-Comédie </a><br>
<a>-Aventure </a><br>
<a>-Science-Fiction </a><br>
</div>


HEREDOC;
			 $html."<br/>";
		$listeFilm = getAllFilms();
		
for($i =0 ; $i < count($listeFilm) ; $i++){
		$idres =	getFilmRealisateurIdById($listeFilm[$i]['film_id']);
		$res = getRealisateurById($idres);		
		$image = getFilmImageIdById($listeFilm[$i]['film_id']); 
		$html .= '<div id="listeFilm">
						<div id="picture">
						<img  src="./images/'.$image.'.jpg"></img>
						</div> 
						<div id="content_info"> 
						<TABLE BORDER="0"> ';
		
		
						$html .="<h3>".$listeFilm[$i]['film_titre']."</h3>" ;
						$html.= '<tr>
						<td>Date :</td>
						<td>'.$listeFilm[$i]['film_date'].'</td> 
								</tr>
								<tr>
						<td>réalisateur :</td><td>'
						.$res[0]['realisateur_prenom'].$res[0]['realisateur_nom'].'</td> 
						
						</tr>
						<tr>
						<td>Acteurs principaux:</td><td></td></tr> 
						<tr>
						<td>Notes : </td><td> </td>
						</tr>
						</table>
	</div>
	<div style="clear:both;"></div>
</div>


';
		}
		echo $html.'</div>' ;
	$doc->end();

?>