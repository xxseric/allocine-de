<?php
    
    /**
    * API Allocin� Helper 2
    * =====================
    * 
    * Utiliser plus facilement l'API d'Allocin�.fr (api.allocine.fr), de Screenrush.co.uk (api.screenrush.co.uk), de Filmstarts.de (api.filmstarts.de), de Beyazperde.com (api.beyazperde.com) ou de Sensacine.com (api.sensacine.com) pour r�cup�rer des informations sur les films, stars, s�ances, cin�s, news, etc...
    * Il est possible de supprimer la classe AlloData sans autre modification du code.
    * 
    * Codes des erreurs:
    * ------------------
    * 1. Aucune fonction de r�cup�ration de donn�es distantes n'est disponible (php_curl|file_get_contents).
    * 2. Erreur durant la r�cup�ration des donn�es sur le serveur d'Allocin�.
    * 3. Erreur durant la conversion des donn�es JSON en array.
    * 4. Les mots-cl�s pour la recherche doivent contenir plus d'un caract�re.
    * 5. Allocin� a retourn� une erreur (Le message de l'erreur est le message de l'ErrorException).
    * 6. offset inexistant (Uniquement dans la classe AlloData).
    * 7. Ce n'est pas un lien vers une image qui a �t� fournit en param�tre � la m�thode __construct() de la classe AlloImage. 
    * 
    * 
    * @licence http://creativecommons.org/licenses/by-nc/2.0/
    * @author Etienne Gauvin
    * @version 2.2
    */
    
    ###################################################################
    ## Modifier les constantes ci-dessous en fonction de vos besoins ##
    ###################################################################
    
    /**
    * L'URL de l'API et du serveur des images (par d�faut).
    * The URL of the API and the server images (default).
    * 
    * @var string
    */
    
    # Allocin�.fr, France
    define( 'ALLO_DEFAULT_URL_API', "api.allocine.fr" );
    define( 'ALLO_DEFAULT_URL_IMAGES', "images.allocine.fr" );
    
    # Screenrush.co.uk, United-Kingdom
    // define( 'ALLO_DEFAULT_URL_API', "api.screenrush.co.uk" );
    // define( 'ALLO_DEFAULT_URL_IMAGES', "images.screenrush.co.uk" );
    
    # Beyazperde.com, T�rkiye
    // define( 'ALLO_DEFAULT_URL_API', "api.beyazperde.com" );
    // define( 'ALLO_DEFAULT_URL_IMAGES', "tri.acimg.net" );
    
    # Filmstarts.de, Deutschland
    // define( 'ALLO_DEFAULT_URL_API', "api.filmstarts.de" );
    // define( 'ALLO_DEFAULT_URL_IMAGES', "bilder.filmstarts.de" );
    
    # Sensacine.com, Espa�a
    // define( 'ALLO_DEFAULT_URL_API', "api.sensacine.com" );
    // define( 'ALLO_DEFAULT_URL_IMAGES', "imagenes.sensacine.com" );
    
    
    /**
    * Activer/d�sactiver les Exceptions
    * Enable/disable Exceptions
    * 
    * @var bool
    */
    
    define( 'ALLO_THROW_EXCEPTIONS', true );
    
    
    /**
    * D�coder de l'UTF8 les donn�es r�ceptionn�es
    * Automatically decode the received data from UTF8
    * 
    * @var bool
    */
    
    define( 'ALLO_UTF8_DECODE', true );
    
    
    /**
    * Le partenaire utilis� pour toutes les requ�tes.
    * The partner used for all requests.
    * 
    * @var string
    */
    
    define( 'ALLO_PARTNER', 'YW5kcm9pZC12M3M' );
    
    
    ###################################################################
    
    
    /**
    * Ex�cuter les requ�tes et traiter les donn�es.
    * 
    */
    
    class AlloHelper
    {
        
        /**
        * Contient la derni�re ErrorException
        * @var ErrorException|null
        */
        
        private static $_lastError;
        
        
        /**
        * Provoquer une ErrorException et/ou retourne la derni�re provoqu�e.
        * 
        * @param string $message=null Le message de l'erreur
        * @param int $code=0 Le code de l'erreur
        * @return ErrorException|null
        */
        
        public static function error( $message = null, $code = 0 )
        {
            if ($message !== null)
            {
                $error = new ErrorException( $message, $code );
                
                if ( ALLO_THROW_EXCEPTIONS )
                    throw $error;
                
                self::$_lastError = $error;
            }
            
            return self::$_lastError;
        }
        
        
        /**
        * Contient l'adresse du site o� chercher les donn�es.
        * @var string
        */
        
        public static $APIUrl = ALLO_DEFAULT_URL_API;
        
        
        /**
        * Contient l'adresse du site o� chercher les images.
        * @var string
        */
        
        public static $imagesUrl = ALLO_DEFAULT_URL_IMAGES;
        
        
        /**
        * Modifier le langage.
        * Les initiales du langage sont telles que d�fini dans la liste des codes ISO 639-1.
        * Le fran�ais (fr), l'allemand (de), l'anglais (en), le turque (tr) et l'espagnol (es) sont disponibles.
        * 
        * @see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
        * 
        * @param string $lang=null Les initiales du langage.
        */
        
        public static function lang( $lang = null )
        {
            switch( (string) $lang )
            {
                case 'de': case 'filmstarts.de':
                    self::$APIUrl = "api.filmstarts.de";
                    self::$imagesUrl = "bilder.filmstarts.de";
                break;
                
                case 'es': case 'sensacine.com':
                    self::$APIUrl = "api.sensacine.com";
                    self::$imagesUrl = "imagenes.sensacine.com";
                break;
                
                case 'fr': case 'allocine.fr':
                    self::$APIUrl = "api.allocine.fr";
                    self::$imagesUrl = "images.allocine.fr";
                break;
                
                case 'en': case 'screenrush.co.uk':
                    self::$APIUrl = "api.screenrush.co.uk";
                    self::$imagesUrl = "images.screenrush.co.uk";
                break;
                
                case 'tr': case 'beyazperde.com':
                    self::$APIUrl = "api.beyazperde.com";
                    self::$imagesUrl = "tri.acimg.net";
                break;
            }
        }
        
        
        /**
        * Pr�r�glages pour les param�tres d'URL
		* @var array
        */
        
        private $_presets = array();
        
        
        /**
        * Ajouter/modifier des pr�r�glages.
        * 
        * @param array|string $preset Si c'est un array alors chaque paire "cl�" => "valeur" ou "cl�=valeur" sera enregistr�e dans les pr�r�glages, sinon si c'est une cha�ne alors c'est le nom du pr�r�glage et $value est sa valeur.
        * @param string|array|int $value La valeur du pr�r�glage si $preset est une cha�ne de caract�res.
        * @return this
        */
        
        public function set( $preset, $value=null )
        {
            if (is_array( $preset ))
                foreach( $preset as $name => $value )
                    $this->_presets[ (string) $name ] = $value;
            
            elseif (is_string( $preset ))
                $this->_presets[ $preset ] = $value;
            
            return $this;
        }
        
        
        /**
        * Retourne les pr�r�glages.
        * 
        * @param string|null $preset=null Indiquer le nom d'un pr�r�glage pour conna�tre sa valeur.
        * @return mixed
        */
        
        public function getPresets( $preset = null )
        {
            if ($preset === null)
                return $this->_presets;
            else
                return @$this->_presets[$preset];
        }
        
        
        /**
        * Effacer un/des pr�r�glages.
        * 
        * @param array $presets=array() Indiquer les pr�r�glages � effacer ou laisser vide pour tout effacer.
        * @param bool $inverse=false Si $inverse vaut true alors tous les pr�r�glages seront effac�s sauf ceux indiqu�s dans $presets.
        * @return this
        */
        
        public function clearPresets( $presets = array(), $inverse = false )
        {
            if (empty($presets))
                $this->_presets = array();
            else {
                if ($inverse)
                    foreach($this->_presets as $psn => $ps)
                        if (!in_array($psn, $presets))
                            unset($this->_presets[$psn]);
                else
                    foreach($presets as $ps)
                        unset($this->_presets[$ps]);
            }
            
            return $this;
        }
        
        
        /**
        * Retourne un URL cr�� � partir de diff�rentes donn�es.
        * Les param�tres seront ajout�s dans l'ordre, sous leur forme "cl�=valeur" ou "valeur" si il n'y a pas de cl�.
        * Si c'est un array les sous �l�ments seront implos�s et s�par�s par des virgules "cl�" => array("val1", "val2", "val3") deviendra "cl�=val1,val2,val3"
        * Les valeurs et les cl�s ne passent pas par la fonction urlencode !
        * 
        * @param string $type Le type de donn�es � r�cup�rer (exemple: "rest/v3/movie")
        */
        
        protected function creatURL( $type )
        {
            $this->set(array(
                'format' => 'json',
                'partner' => ALLO_PARTNER
            ));
            
            $options_str = array();
            
            foreach ($this->getPresets() as $cle => $valeur) {
                if (is_string($cle))
                {
                    if (is_array($valeur))
                        $options_str[] = "$cle=" . implode(',', $valeur);
                    
                    else
                        $options_str[] = "$cle=" . (string) $valeur;
                }
                else
                    $options_str[] = (string) $valeur;
            }
            
            return "http://". self::$APIUrl ."/$type?".implode('&',(array)$options_str);
        }
        
        
        /**
        * R�cup�rer des donn�es JSON et les convertir depuis un URL gr�ce � php_curl, ou � d�faut file_get_contents().
        * 
        * @param string $url L'URL vers lequel aller chercher les donn�es JSON.
        * @return array|false Un array contenant les donn�es en cas de succ�s, false si une erreur est survenue.
        */
        
        protected function getDataFromURL ( $url )
        {
            if ( function_exists("curl_init") )
            {
                $curl = curl_init();
                curl_setopt ($curl, CURLOPT_URL, $url);
                curl_setopt ($curl, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt ($curl, CURLOPT_RETURNTRANSFER, true);
                $data = curl_exec($curl);
                curl_close($curl);
            }
            
            else
            {
                if ( !function_exists("file_get_contents") )
                {
                    $this->error("The extension php_curl must be installed with PHP or function file_get_contents must be enabled.", 1);
                    return false;
                }
                else
                    $data = @file_get_contents($url);
            }
            
            if (empty($data))
            {
                $this->error("An error occurred while retrieving the data.", 2);
                return false;
            }
            
            $data = @json_decode( $data, 1 );
            
            if (empty($data)) {
                $this->error("An error occurred when converting data.", 3);
                return false;
            }
            else return $data;
        }
        
        
        /*
        * M�thodes de r�cup�ration des donn�es
        */
        
        /**
        * R�cup�rer les donn�es pour un type de donn�es et un �l�ment du tableau retourn� donn�.
        * Utilis� en interne pour diminuer et clarifier le code dans les m�thodes ne n�cessitant pas de traitement particulier sur leurs donn�es.
        * 
        * @param string $type Voir AlloHelper::creatURL()
        * @param string $container L'�l�ment contenant les donn�es dans le tableau retourn� par Allocin�
        * @return AlloData|array|false
        */
        
        protected function getData( $type, $container, &$url )
        {
            // R�cup�ration des donn�es
            $data = $this->getDataFromURL( $url = $this->creatURL( $type ) );
            
            // En cas d'erreur
            if (empty( $data ))
                return false;
                
            // Succ�s ($data est encore un array)
            else
            {
                if (empty($data['error']))
                    // On retourne les donn�es
                    if (class_exists('AlloData'))
                        return new AlloData( $data[$container] );
                    else
                        return $data;
                
                // En cas d'erreur signal�e par Allocin�
                else
                {
                    $this->error( $data['error']['$'], 5 );
                    return false;
                }
            }
        }
        
        /**
        * Effectuer une recherche sur Allocin�.
        * Possibilit� de trier les r�sultats de films par ressemblance avec la cha�ne de recherche.
        * 
        * @param string $q La cha�ne de recherche.
        * @param int $page=1 La page des r�sultats.
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param bool $sortMovies=false R�organiser ou non les films selon la ressemblance entre leur titre et la cha�ne de recherche.
        * @param array $filter=array() Filtrer les r�sultats pour gagner en rapidit�. Peut-�tre remplit par "movietheater", "movie", "theater", "person", "news", "tvseries", "location", "character", "video" ou "photo".
        * @param &$url=null Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function search( $q, $page = 1, $count = 10, $sortMovies = false, array $filter = array(), &$url = null )
        {
            
            // Traitement de la cha�ne de recherche
            if (!is_string($q) || strlen($q) < 2 )
            {
                $this->error( "The keywords should contain more than one character.", 4 );
                return false;
            }
            
            $accents = "��������������������������'";
            $normal  = 'aaaaaceeeeiiiinooooouuuuyy ';
            $q = utf8_encode(strtr(strtolower(trim($q)), $accents, $normal));
            
            // Pr�r�glages
            $this->set(array(
                'q' => urlencode($q),
                'filter' => (array) $filter,
                'count' => (int) $count,
                'page' => (int) $page
            ));
            
            // Cr�ation de l'URL
            $url = $this->creatURL( 'rest/v3/search' );
            
            // Envoi de la requ�te
            $data = $this->getDataFromURL( $url );
            
            // En cas d'erreur
            if (empty($data))
                return false;
                
            // Succ�s ($data est encore un array)
            else
            {
                if (empty($data['error']))
                {
                    $data = $data['feed'];
                    
                    if (!empty($data['movie']))
                    {
                        foreach ($data['movie'] as $iresult => &$result)
                        {
                            $result['productionYear'] = (int) @$result['productionYear'];
                            $result['originalTitle'] = (string) @$result['originalTitle'];
                            
                            if (empty($result['title']))
                                $result['title'] = @$result['originalTitle'];
                            
                            $result['release'] = (array) @$result['release'];
                            $result['release']['releaseDate'] = (string) @$result['release']['releaseDate'];
                            
                            $result['statistics'] = (array) @$result['statistics'];
                            $result['statistics']['pressRating'] = (float) @$result['statistics']['pressRating'];
                            $result['statistics']['userRating'] = (float) @$result['statistics']['userRating'];
                            
                            $result['castingShort'] = (array) @$result['castingShort'];
                            $result['castingShort']['directors'] = (string) @$result['castingShort']['directors'];
                            $result['castingShort']['actors'] = (string) @$result['castingShort']['actors'];
                            
                            if (!empty($result['poster']['href']))
                                $result['poster'] = new AlloImage($result['poster']['href']);
                            else
                                $result['poster'] = new AlloImage();
                            
                            $result['posterURL'] = $result['poster']->url();
                            $result['link'] = (array) @$result['link'];
                        }
                    }
                    
                    // R�organisation des films
                    if ($sortMovies && !empty($data['movie']))
                    {
                        $movies = &$data['movie'];
                        $resultats = array();
                        
                        // Tableau contenant $cleFilm => $similitude
                        $similitudes = array();
                        
                        // Oncalcule la distance de levenstein entre la cha�ne de recherche et le titre pour chaque film
                        foreach ($movies as $i => &$m)
                            $similitudes[$i] = levenshtein($q, strtr(strtolower($m['title']), $accents, $normal));
                        
                        // On r�organise le tableau des similitudes, mais en gardant les cl�s.
                        asort($similitudes, true);
                        
                        // On remplit le tableau des r�sultats dans l'ordre des similitudes.
                        foreach ($similitudes as $i => $sim)
                            $resultats[] = $movies[$i];
                        
                        
                        $data['movieSorted'] = $resultats;
                        $data['movie'] = $movies;
                    }
                    
                    // R�organisation des compteurs des r�sultats
                    if (!empty($data['results']))
                    {
                        foreach ($data['results'] as $r)
                            $data['results'][$r['type']] = (int) $r['$'];
                    }
                    
                    // On retourne les donn�es
                    if (class_exists('AlloData'))
                        return new AlloData( $data );
                    else
                        return $data;
                }
                
                // En cas d'erreur signal�e par Allocin�
                else
                {
                    $this->error( $data['error']['$'], 5 );
                    return false;
                }
            }
        }
        
        
        /**
        * R�cup�rer les critiques des spectateurs et de la presse � propos d'un film, d'une s�rie TV.
        * 
        * @param int $code L'identifiant du film/de la s�rie.
        * @param string $filter='press' Le type de critique ('press' ou 'public') � renvoyer.
        * @param string $type='movie' Le type de donn�es ("movie" ou "tvseries") auquel faire correspondre l'identifiant $code.
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param int $page=1 La page des r�sultats.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function reviewlist( $code, $filter='press', $type='movie', $count = 10, $page = 1, &$url = null )
        {
            // Type de critiques (presse/public)
            switch ($filter)
            {
                case 'press': case 'presse': case 'desk-press':
                $filter = 'desk-press';
                break;
                
                default:
                $filter = 'public';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => $code,
                'filter' => (array) $filter,
                'type' => (string) $type,
                'count' => (int) $count,
                'page' => (int) $page
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/reviewlist', 'feed', $url);
        }
        
        
        /**
        * R�cup�rer une liste de films en fonction de diff�rents param�tres.
        * 
        * @param string $filter='nowshowing' Le type de r�sultats � afficher: 'nowshowing' (films au cin�ma) ou 'comingsoon' (bient�t au cin�ma);
        * @param string $order='dateasc' L'ordre dans lequel afficher les donn�es: 'dateasc' (chronologique), 'datedesc' (anti-chronologique), 'theatercount' (nombre de salles) ou 'toprank' (popularit�).
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param int $page=1 La page des r�sultats.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function movielist( $filter=array('nowshowing'), $order=array('dateasc'), $count = 10, $page = 1, &$url = null )
        {
            // Pr�r�glages
            $this->set(array(
                'filter' => (array) $filter,
                'order' => (array) $order,
                'count' => (int) $count,
                'page' => (int) $page
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/movielist', 'feed', $url);
        }
        
        
        /**
        * R�cup�rer une liste de cin�mas et la liste des films qui y passent actuellement en fonction d'un code postal.
        * 
        * @param mixed $zip Le code postal de la ville du/des cin�ma(s).
        * @param $date=null Sp�cifier une date pour les horaires.
        * @param $movieCode=null Sp�cifier les horaires d'un film (par identifiant).
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param int $page=1 La page des r�sultats.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function showtimesByZip( $zip, $date=null, $movieCode=null, $count = 10, $page = 1, &$url = null )
        {
            // Pr�r�glages
            $this->set('zip', $zip);
            $this->set('count', (int) $count);
            $this->set('page', (int) $page);
            
            if ($date !== null)
                $this->set('date', $date);
            
            if ($movieCode !== null)
                $this->set('movie', $movieCode);
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/showtimelist', 'feed', $url);
        }
        
        
        
        /**
        * R�cup�rer une liste de cin�mas et la liste des films qui y passent actuellement en fonction de coordonn�es g�ographiques (latitude, longitude [, rayon]).
        * 
        * @param float $lat La coordonn�e latitude du cin�ma.
        * @param float $long La coordonn�e longitude du cin�ma.
        * @param int $radius Le rayon dans lequel chercher.
        * @param $date=null Sp�cifier une date pour les horaires.
        * @param $movieCode=null Sp�cifier les horaires d'un film (par identifiant).
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param int $page=1 La page des r�sultats.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function showtimesByPosition( $lat, $long, $radius=10, $date=null, $movieCode=null, $count = 10, $page = 1, &$url = null )
        {
            // Pr�r�glages
            $this->set('lat', (float) $lat);
            $this->set('long', (float) $long);
            $this->set('radius', (int) $radius);
            $this->set('count', (int) $count);
            $this->set('page', (int) $page);
            
            if ($date !== null)
                $this->set('date', $date);
            
            if ($movieCode !== null)
                $this->set('movie', $movieCode);
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/showtimelist', 'feed', $url);
        }
        
        
        
        /**
        * R�cup�rer une liste de cin�mas et la liste des films qui y passent actuellement en fonction d'un ou de plusieurs identifiant(s) de cin�ma(s);
        * 
        * @param array|string $theaters Un identifiant/une liste d'identifiants de cin�ma(s).
        * @param $date=null Sp�cifier une date pour les horaires.
        * @param $movieCode=null Sp�cifier les horaires d'un film (par identifiant).
        * @param int $count=10 Le nombre maximum de r�sultats par page.
        * @param int $page=1 La page des r�sultats.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function showtimesByTheaters( $theaters, $date=null, $movieCode=null, $count = 10, $page = 1, &$url = null )
        {
            // Pr�r�glages
            $this->set('theaters', (array) $theaters);
            $this->set('count', (int) $count);
            $this->set('page', (int) $page);
            
            if ($date !== null)
                $this->set('date', $date);
            
            if ($movieCode !== null)
                $this->set('movie', $movieCode);
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/showtimelist', 'feed', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur un film.
        * 
        * @param int $code L'identifiant du film.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function movie( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // Cr�ation de l'URL
            $url = $this->creatURL( 'rest/v3/movie' );
            
            // Envoi de la requ�te
            $data = $this->getDataFromURL( $url );
            
            // En cas d'erreur
            if (empty($data))
                return false;
                
            // Succ�s ($data est encore un array)
            else
            {
                if (empty($data['error']))
                {
                    $data = $data['movie'];
                    
                    // Remplacer "title" par "originalTitle" (si il n'existe pas)
                    if (empty($data['title']))
                        $data['title'] = $data['originalTitle'];
                    
                    // On retourne les donn�es
                    if (class_exists('AlloData'))
                        return new AlloData( $data );
                    else
                        return $data;
                }
                
                // En cas d'erreur signal�e par Allocin�
                else
                {
                    $this->error( $data['error']['$'], 5 );
                    return false;
                }
            }
        }
        
        
        /**
        * R�cup�rer toutes les informations sur un article.
        * 
        * @param int $code L'identifiant de l'article.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function news( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/news', 'news', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur une personne.
        * 
        * @param int $code L'identifiant de la personne.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function person( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/person', 'person', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur un media (vid�o/photo).
        * 
        * @param int $code L'identifiant du media.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function media( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/media', 'media', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur la filmographie d'une personne.
        * 
        * @param int $code L'identifiant de la personne.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function filmography( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/filmography', 'person', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur une s�rie TV.
        * 
        * @param int $code L'identifiant de la s�rie TV.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function tvserie( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/tvseries', 'tvseries', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur une saison d'une s�rie TV.
        * 
        * @param int $code L'identifiant de la saison.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function season( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/season', 'season', $url);
        }
        
        
        /**
        * R�cup�rer toutes les informations sur un �pisode d'une saison d'une s�rie TV.
        * 
        * @param int $code L'identifiant de l'�pisode.
        * @param int $profile='medium' La quantit� d'informations � renvoyer: 'small', 'medium', 'large', 1 pour 'small', 2 pour 'medium', 3 pour 'large'.
        * @param &$url Contiendra l'URL utilis�.
        * 
        * @return AlloData|array|false
        */
        
        public function episode( $code, $profile = 'medium', &$url = null )
        {
            // Profile (quantit� d'informations)
            switch($profile)
            {
                case 'small': break;
                case 'large': break;
                default: $profile = 'medium'; break;
                
                case 1: $profile = 'small'; break;
                case 3: $profile = 'large';
            }
            
            // Pr�r�glages
            $this->set(array(
                'code' => (int) $code,
                'profile' => (string) $profile,
            ));
            
            // R�cup�ration et revoi des donn�es
            return $this->getData('rest/v3/episode', 'episode', $url);
        }
        
    }
    
    
    /**
    * Manipuler facilement les donn�es re�ues.
    * Il est possible de supprimer compl�tement cette classe sans autre modification du code.
    * 
    * @implements ArrayAccess, SeekableIterator, Countable
    */
    
    class AlloData implements ArrayAccess, SeekableIterator, Countable
    {
        
        /**
        * Contiendra les donn�es
        * @var array
        */
        
        private $_data = array();
        
        
        /**
        * Valeur de remplacement pour les symboles '$' ou false pour ne rien modifier.
        */
        
        const REPLACEMENT_OF_DOLLAR_SIGN = 'value';
        
        
        /**
        * D�coder une variable depuis l'UTF8.
        * 
        * @param mixed $var Seules les cha�nes sont d�cod�es, mais aucune erreur ne sera provoqu�e si ce n'en est pas une.
        * @param mixed $tab=false Si ce param�tre vaut true alors le tableau sera parcouru de mani�re r�cursive et toutes les cha�nes de caract�rezs seront converties.
        * @return array|string Le tableau|la cha�ne d�cod�(e)
        */
        
        public static function utf8_decode( $var, $tab = false )
        {
            if (ALLO_UTF8_DECODE)
            {
                if (is_string($var)) return utf8_decode(str_replace('’', "'", $var));
                elseif (!is_array($var) || !$tab) return $var;
                else
                {
                    $return = array();
                    foreach ($var as $i => $cell)
                        $return[utf8_decode($i)] = self::utf8_decode($cell, true);
                    return $return;
                }
            }
            else
                return $var;
        }
        
        
        /**
        * Constructeur
        */
        
        public function __construct( $data )
        {
            $this->_data = (array) $data;
        }
        
        
        /**
        * Retourne un pointeur sur une valeur existante dans les donn�es enregistr�es, ou null si elle n'existe pas.
        * 
        * @param $offset=null Retourne un pointeur sur tout le tableau si $offset==null
        * @return Une r�f�rence vers la valeur demand�e, ou null si elle n'existe pas.
        */
        
        protected function &_getProperty( $offset = null, $ignoreException = false )
        {
            $data = &$this->_data;
            
            if ( $offset === null )
                return $data;
            
            else
            {
                if (isset( $data[$offset] ))
                    return $data[$offset];
                
                
                elseif ( $offset == self::REPLACEMENT_OF_DOLLAR_SIGN && isset($data['$']) )
                    return $data['$'];
                
                else
                    if (!$ignoreException)
                        AlloHelper::error("This offset ($offset) does not exist.", 6);
            }
        }
        
        /**
        * Retourne les donn�es sous forme d'un array
        * 
        */
        
        public function getArray()
        {
            return (array) self::utf8_decode($this->_getProperty(), true);
        }
        
        
        /**
        * Si l'on essaie d'acc�der � une propri�t� inexistante (donc un �l�ment de $this->_data)
        * 
        */
        
        public function __get( $offset )
        {
            $data = $this->_getProperty($offset);
            if (is_array($data))
                return new AlloData( $data );
            else return self::utf8_decode($data);
        }
        
        
        /**
        * Impossible de cr�er/modifier une propri�t�
        * 
        */
        
        public function __set( $offset, $value )
        {
            $data = &$this->_getProperty($offset);
            $data = $value;
        }
        
        
        /*
        * Impl�mentation des interfaces
        */
        
        /**
        * Pointeur interne
        * @var int
        */
        
        private $_position = 0;
        
        /**
        * Retourne la valeur de l'index courant.
        */
        
        public function current( )
        {
            $data = $this->_getProperty($this->_position);
            if (is_array($data))
                return new AlloData( $data );
            else return self::utf8_decode($data);
        }
        
        /**
        * Retourne true ou false selon l'existence ou non d'une occurence dans les donn�es.
        */
        
        public function valid( )
        {
            return ($this->_getProperty($this->_position, true) !== null);
        }
        
        /**
        * Retourne la position actuelle.
        */
        
        public function key( )
        {
            return $this->_position;
        }
        
        /**
        * Incr�mente l'index.
        */
        
        public function next( )
        {
            $this->_position++;
        }
        
        
        /**
        * R�initialise l'index.
        */
        
        public function rewind( )
        {
            $this->_position = 0;
        }
        
        
        /**
        * Pour modifier directement la position dans le tableau.
        */
        
        public function seek( $newPosition )
        {
            $lastPosition = $this->_position;
            $this->_position = $newPosition;
            
            if (!$this->valid())
            {
                AlloHelper::error("This offset ($offset) does not exist.", 6);
                $this->position = $anciennePosition;
            }
        }
        
        
        /**
        * Retourne le nombre d'occurences dans le tableau.
        */
        
        public function count()
        {
            return count($this->_data);
        }
        
        /**
        * Si l'on essaie d'acc�der � l'objet comme � un tableau.
        */
        
        public function offsetGet( $offset )
        {
            $data = $this->_getProperty($offset);
            if (is_array($data))
                return new AlloData( $data );
            else return self::utf8_decode($data);
        }
        
        
        /**
        * Si l'on veut de cr�er/modifier une propri�t� (interface ArrayAccess)
        */
        
        public function offsetSet( $offset, $value )
        {
            $data = &$this->_getProperty($offset);
            $data = $value;
        }
        
        
        /**
        * Lors de la v�rification de l'existence d'une propri�t� avec isset (interface ArrayAccess)
        */
        
        public function offsetExists( $offset )
        {
            return ($this->_getProperty($this->_position, true) !== null);
        }
        
        
        /**
        * Il n'est pas possible de d�truire une la variable r�f�renc�e, seule la r�f�rence est d�truite...
        * De toute fa�on �a n'a pas d'utilit�.
        */
        
        public function offsetUnset($offset)
        {
            return;
        }
        
        
        /**
        * Coller toutes les valeurs/sous-valeurs du tableau associatif.
        * Exemple : $film->genre->implode( 'value' ) implosera toutes les valeurs de $film->genre[i]->value
        * 
        * @param string $separator=', '         Le s�parateur des valeurs.
        * @param string $lastSeparator=' et '   Le s�parateur des derni�re et l'avant-derni�re valeurs.
        * @param string $offset='value'         Les offsets � concat�ner ('$' == 'value').
        */
        
        public function implode( $separator = ', ', $lastSeparator = ' et ', $offset = 'value' )
        {
            $tab = (array) $this->_getProperty();
            
            if ( count($tab) === 1 )
            {
                $data = new AlloData($tab[0]);
                if ( isset($data[$offset]) && is_string($data[$offset]) )
                    return $data[$offset];
            }
            
            elseif ( count($tab) < 1 )   return '';
            
            $values = array();
            
            foreach ( $tab as $i => $stab )
            {
                $data = new AlloData( $stab );
                if ( isset($data[$offset]) && is_string($data[$offset]) )
                    $values[] = $data[$offset];
            }
            
            $last = array_slice($values, -1, 1);
            
            if ( $values )
                return implode( (string) $separator, array_slice( $values, 0, -1 ) ) . (( count($values) > 1 ) ? (string) $lastSeparator . $last[0] : '' );
            else
                return '';
        }
        
    }
    
    
    /**
    * Manipuler facilement les URLs des images.
    * 
    */
    
    class AlloImage
    {
        
        /**
        * R�pertoire de l'image par d�faut
        * @const string
        */
        
        const DEFAULT_IMAGE_PATH = "commons/emptymedia/AffichetteAllocine.gif";
        
        
        /**
        * Liste des ic�nes diponibles
        * @var array
        */
        
        public static $icons = array(
            'play.png' => null,
            'overplay.png' => null,
            'overlayVod120.png' => array('r', 120, 160),
        );
        
        
        /**
        * Contient les param�tres de l'ic�ne.
        * @var array|false
        */
        
        private $imageIcon = false;
        
        
        /**
        * Contient les param�tres de la bordure
        * @var array|false
        */
        
        private $imageBorder = false;
        
        
        /**
        * Contient les param�tres de la taille de l'image.
        * @var array|false
        */
        
        private $imageSize = false;
        
        
        /**
        * Contient l'adresse du serveur de l'image.
        * @var string
        */
        
        private $imageHost;
        
        
        /**
        * Contient le r�pertoire de l'image sur Allocin�.
        * @var string
        */
        
        private $imagePath;
        
        
        /**
        * Image par d�faut
        * 
        * @return this
        */
        
        public function reset( )
        {
            $this->destroyBorder();
            $this->destroyIcon();
            $this->maxSize();
            
            return $this;
        }
        
        /**
        * Modifier l'ic�ne sur l'image.
        * 
        * @param string $position='c' La position de l'ic�ne par rapport au centre de l'image (en une ou deux lettres), d'apr�s la rose des sable. Renseigner une position invalide (telle que 'c') pour centrer l'ic�ne.
        * @param int $margin=4 Le nombre de pixel entre l'ic�ne et le(s) bord(s) le(s) plus proche(s).
        * @param string $icon='play.png' Le nom de l'ic�ne � ajouter. La liste des ic�nes se trouve dans AlloImage::$icons.
        * @return this
        */
        
        public function icon( $position='c', $margin=4, $icon='play.png' )
        {
            if (!empty($this->icons[$icon]))
            {
                $p = $this->icons[$icon];
                
                switch ($p[0])
                {
                    case 'r': $this->resize($p[1], $p[2]); break;
                    case 'c': $this->cut($p[1], $p[2]); break;
                }
            }
            
            $this->imageIcon = array(
                'position' => substr($position, 0, 2),
                'margin' => (int) $margin,
                'icon' => (string) $icon
            );
            
            return $this;
        }
        
        
        /**
        * Renvoie les param�tres enregistr�s pour l'ic�ne.
        * 
        * @return array|false
        */
        
        public function getIcon()
        {
            return $this->imageIcon;
        }
        
        
        /**
        * Efface les param�tres enregistr�s pour l'ic�ne.
        * 
        * @return this
        */
        
        public function destroyIcon()
        {
            $this->imageIcon = false;
            return $this;
        }
        
        
        /**
        * Modifier la bordure de l'image.
        * 
        * @param int $size=1 L'�paisseur de la bordure en pixels.
        * @param string $color='000000' La couleur de la bordure en hexad�cimal (sans # initial). [http://en.wikipedia.org/wiki/Web_colors#Hex_triplet]
        * @return this
        */
        
        public function border( $size=1, $color="000000" )
        {
            $this->imageBorder = array(
                'size' => (int) $size,
                'color' => (string) $color
            );
            
            return $this;
        }
        
        
        /**
        * Renvoie les param�tres enregistr�s de la bordure.
        * 
        * @return array|false
        */
        
        public function getBorder()
        {
            return $this->imageBorder;
        }
        
        
        /**
        * Efface la bordure.
        * 
        * @return this
        */
        
        public function destroyBorder()
        {
            $this->imageBorder = false;
            return $this;
        }
        
        
        /**
        * Modifier proportionnellement la taille de l'image au plus petit.
        * Si les deux param�tres sont laiss�s tels quels ($xmax='x' et $ymax='y'), l'image sera de taille normale.
        * Appeler cette fonction efface les param�tres enregistr�s pour AlloImage::cut() (Les deux m�thodes ne peuvent �tre utilis�es en m�me temps).
        * 
        * @param int $xmax='x' La largeur maximale de l'image, en pixels. Laisser 'x' pour une largeur automatique en fonction de $ymax.
        * @param int $ymax='y' La hauteur maximale de l'image, en pixels. Laisser 'y' pour une hauteur automatique en fonction de $xmax.
        * @return this
        */
        
        public function resize( $xmax='x', $ymax='y' )
        {
            $this->imageSize = array(
                'method' => 'r',
                'xmax' => $xmax,
                'ymax' => $ymax
            );
            
            return $this;
        }
        
        
        /**
        * Redimensionner l'image au plus petit, puis couper les bords trop grands.
        * Appeler cette fonction efface les param�tres enregistr�s pour AlloImage::resize() (Les deux m�thodes ne peuvent �tre utilis�es en m�me temps).
        * 
        * @param int $xmax La largeur maximale de l'image, en pixels.
        * @param int $ymax La hauteur maximale de l'image, en pixels.
        * @return this
        */
        
        public function cut( $xmax, $ymax )
        {
            $this->imageSize = array(
                'method' => 'c',
                'xmax' => (int) $xmax,
                'ymax' => (int) $ymax
            );
            
            return $this;
        }
        
        
        /**
        * Retourne les param�tres enregistr�s du redimensionnement/recoupe de l'image.
        * 
        * @return array|false
        */
        
        public function getSize()
        {
            return $this->imageSize;
        }
        
        
        /**
        * R�gle l'image � sa taille maximale (Effacer redimensionnement/recoupe)
        * 
        * @return array|false
        */
        
        public function maxSize()
        {
            $this->imageSize = false;
            return $this;
        }
        
        
        /**
        * Retourne le host de l'image.
        * 
        * @return string
        */
        
        public function getImageHost()
        {
            return $this->imageHost;
        }
        
        
        /**
        * Modifier le serveur (host) de l'image.
        * 
        * @param string $server L'adresse sans slash du serveur (ex: 'images.allocine.fr'), le m�me param�tre que pour AlloHelper::lang(), ou 'default' pour r�gler selon le langage enregistr�.
        * @return this
        */
        
        public function setImageHost( $server )
        {
            switch ($server)
            {
                case 'default':
                case 'de': case 'filmstarts.de':
                case 'es': case 'sensacine.com':
                case 'fr': case 'allocine.fr':
                case 'en': case 'screenrush.co.uk':
                    $this->imageHost = self::$imagesUrl;
                break;
                
                default:
                    $this->imageHost = $server;
            }
            
            return $this;
        }
        
        
        /**
        * Cr�er une nouvelle image gr�ce � son URL.
        * Si l'url est invalide, l'image utilis�e sera celle par d�faut.
        * 
        * @param string $url=null L'URL de l'image.
        */
        
        public function __construct( $url = null )
        {
            if ( empty($url) || !filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED) )
            {
                $this->imageHost = AlloHelper::$imagesUrl;
                $this->imagePath = self::DEFAULT_IMAGE_PATH;
                
            }
            else
            {
                $urlParse = parse_url($url);
                
                $this->imageHost = !empty($urlParse['host']) ? $urlParse['host'] : AlloHelper::$imagesUrl;
                
                if (!empty($urlParse['path']))
                    $this->imagePath = $urlParse['path'];
                else
                    AlloHelper::error("This isn't a URL to an image.", 7);
                
                // Parsage de l'URL
                $explodePath = explode('/', $this->imagePath);
                
                // Premi�re partie vide ?
                if (empty($explodePath[0]))
                    unset($explodePath[0]);
                
                // D�tecte les param�tres jusqu'au d�but du path r�el.
                foreach ($explodePath as $iPathPart => $pathPart)
                {
                    if (strpos($pathPart, '_') === false)
                        break;
                    else
                        unset($explodePath[$iPathPart]);
                    
                    // Ic�ne
                    if (strpos($pathPart, 'o') === 0 && preg_match("#^o_(.+)_(.+)_(.+)$#i", $pathPart, $i) != false)
                    {
                        $this->icon($i[3], $i[2], $i[1]);
                    }
                    
                    // Bordure
                    elseif (strpos($pathPart, 'b') === 0 && preg_match("#^b[xy]?_([0-9]+)_([0-9a-f]{6}|.*)$#i", $pathPart, $i) != false)
                    {
                        if (preg_match("#^[0-9a-f]{6}$#i", $i[2]) == false)
                            $i[2] = "000000";
                        
                        $this->border($i[1], $i[2]);
                    }
                    
                    // Redimensionnement
                    elseif (preg_match("#^r[xy]?_([0-9]+|[a-z0-9]+)_([0-9]+|[a-z0-9]+)$#i", $pathPart, $i) != false)
                    {
                        $this->resize((int) $i[1], (int) $i[2]);
                    }
                    
                    // Recoupe
                    elseif (preg_match("#^c[xy]?_([0-9]+|[a-z0-9]+)_([0-9]+|[a-z0-9]+)$#i", $pathPart, $i) != false)
                    {
                        $this->cut((int) $i[1], (int) $i[2]);
                    }
                }
                
                $this->imagePath = implode('/', $explodePath);
            }
        }
        
        
        /**
        * Construit l'URL � partir des param�tres enregistr�s.
        * 
        * @return string
        */
        
        public function url()
        {
            $params = array();
            
            // Taille
            if ( $this->imageSize !== false )
                $params[] = "{$this->imageSize['method']}_{$this->imageSize['xmax']}_{$this->imageSize['ymax']}";
            
            // Bordure
            if ( $this->imageBorder !== false )
                $params[] = "b_{$this->imageBorder['size']}_{$this->imageBorder['color']}";
            
            // Ic�ne
            if ( $this->imageIcon !== false )
                $params[] = "o_{$this->imageIcon['icon']}_{$this->imageIcon['margin']}_{$this->imageIcon['position']}";
            
            return "http://{$this->imageHost}" . (!empty($params) ? '/' . implode('/', $params) : '') . "/{$this->imagePath}";
        }
        
        
        /**
        * Alias de AlloImage::url()
        * 
        * @return string
        */
        
        public function __toString()
        {
            return $this->url();
        }
        
    }

