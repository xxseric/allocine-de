<?php
//Chargement de Doctrine
require_once ( dirname(__FILE__) . '/Doctrine/Doctrine.php');
//Inscription de l'autoloader
spl_autoload_register( array ( 'Doctrine', 'autoload' ));
spl_autoload_register( array ( 'Doctrine_Core', 'modelsAutoload' )) ;
//Définition des paramètres de connexion
$hostname = '127.0.0.1';
$database = 'Allocine';
$user = 'admin';
$password = 'admin';
//Création du DNS
$dns = 'mysql://' . $user . ':' . $password . '@' . $hostname . '/' . $database;
//Création de la connexion
$manager = Doctrine_Manager :: getInstance();
$conn = Doctrine_Manager :: connection($dns, 'doctrine');
//Configuration de la connexion
$conn->setOption('username', $user);
$conn->setOption('password', $password);
$manager->setAttribute(Doctrine_Core :: ATTR_VALIDATE, Doctrine_Core :: VALIDATE_ALL);
$manager->setAttribute(Doctrine_Core :: ATTR_EXPORT, Doctrine_Core :: EXPORT_ALL);
$manager->setAttribute(Doctrine_Core :: ATTR_MODEL_LOADING, Doctrine_Core :: MODEL_LOADING_CONSERVATIVE);
		Doctrine_Core::loadModels(dirname(__FILE__) . '/../models');
?>
