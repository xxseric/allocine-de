<?php
$name = "matrix";                 // the name will usually be dynamically set
require_once("./php4-imdbonly/trunk/imdb.class.php");       // include the class file - for Moviepilot: pilot.class.php
require_once("./php4-imdbonly/trunk/imdbsearch.class.php"); // for Moviepilot: pilotsearch.class.php
$search = new imdbsearch();           // create an instance of the search class. For Moviepilot: $search = new pilotsearch();
$search->setsearchname($name);        // tell the class what to search for (case insensitive)
$results = $search->results();        // submit the search





$movie   = new imdb('0133093');         // create an instance of the class and pass it the IMDB ID
					   					// For Moviepilot: new pilot($mid)
$title   = $movie->title();        		// retrieve the movie title
$year    = $movie->year();         		// obtain the year of production
//$runtime = $movie->runtime();      		// runtime in minutes
$rating  = $movie->mpaa();         		// array[country=>rating] of ratings
$trailer = $movie->trailers();     		// array of trailers
$type	 = $movie->movieTypes();
$genre = $movie->genres();
echo $title."</br>".$year."</br>".$runtime."</br>" ;

print_r($rating) ;
print_r($trailer);

?>