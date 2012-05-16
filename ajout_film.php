<?php

	require_once 'persistence/user_dao.php';
	require_once 'persistence/realisateur_dao.php';
	require_once 'persistence/acteur_dao.php';
	require_once 'persistence/film_dao.php';
	require_once 'persistence/listeActeur_dao.php';
	require_once 'persistence/categorieFilm_dao.php';

echo "<div id='gestion_user'>

<form action='./ajout_film.php' method=POST >
<label>Id imdb : </label><input type='text' id='ajout_1' name='ajout_1'/> 
<input type='submit' value='rechercher'  />
</form>
</div>" ;



if(isset($_POST['ajout_1'])){
require_once("./php4-imdbonly/trunk/imdb.class.php");       // include the class file - for Moviepilot: pilot.class.php
require_once("./php4-imdbonly/trunk/imdbsearch.class.php"); // for Moviepilot: pilotsearch.class.php


$movie   = new imdb($_POST['ajout_1']);         // create an instance of the class and pass it the IMDB ID
					   					// For Moviepilot: new pilot($mid)
$title   = $movie->title();        		// titre
$year    = $movie->releaseInfo();         		// année
//$runtime = $movie->runtime();      		// runtime in minutes
$rating  = $movie->mpaa();         		// 
$trailer = $movie->trailers();     		// genre
$genre = $movie->genres();
$realisateur = $movie->director();
$resumer = $movie->storyline();
$acteurs = $movie->cast();
$image = $movie->photo();
//echo $movie->savephoto("http://localhost/Allocine/trunk/images/");

echo $title."</br>".$year[1]['day'].$year[1]['mon'].$year[1]['year']."</br>"."</br>" ;

$res = $realisateur[0]['name'];

for($i = 0 ; $i < count($genre) ; $i++){
	echo $genre[$i]."</br>" ;
}

echo "</br>";

for($i = 0 ; $i < count($acteurs) ; $i++){
	echo $acteurs[$i]['name']."</br>";
}

echo "</br>".$res."</br>" ;

echo "</br>".$resumer."</br>" ;

// L'url du fichier
$url = $image;
// Le chemin de sauvegarde
$path = './images/';
// On recup le nom du fichier
$name = array_pop(explode('/',$url));
// On copie le fichier
copy($url,$path.'/'.$_POST['ajout_1'].'.jpg');


///////////////////////ajout du film /////////////////////////////////
							//verifie si le realisateur à déja été ajouter
							$resVal = explode( " " ,$res);
							if(!(getRealisateurIdByPrenom($resVal[0]) == -1 && getRealisateurIdByNom($resVal[1]) == -1)){							
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}else if (!(getRealisateurIdByNom($resVal[0]) == -1 && getRealisateurIdByPrenom($resVal[1]) == -1)){						
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}else{
								addRealisateur($resVal[1],$resVal[0]); //ajout du réalisateur si il est pas dans la bdd
								$resId = getRealisateurIdByPrenom($resVal[0]) ;
							}

				//ajout du film
				//date = 2012-05-09 Y-M-D
				 
				$date =  $year[1]['year']."-".$year[1]['mon']."-".$year[1]['day'] ;
				echo $date ;
				
				addFilm($title,$date,$_POST['ajout_1'],$resId, null ,$resumer,null,null,null,null);
						
				$id_film=getFilmIdByTitre($title);		
				
				for($i = 0 ; $i < count($acteurs) ; $i++){
								$actVal = explode(" ", $acteurs[$i]['name']);
											if(acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]) == -1 ){
												addActeur($actVal[1],$actVal[0]);
											}
								$actId	= acteur_getIdbyNomEtPrenom($actVal[1],$actVal[0]);
								addListeActeur($id_film,$actId);
				}
							
				
			
				
				for($i = 0 ; $i < count($genre) ; $i++){
					addCategorieFilm($genre[$i]);
					$id_cat = getCategorieFilmIdByLib($genre[$i]);
					addListeCategorieFilm($id_film, $id_cat);
				}
					


}
?>