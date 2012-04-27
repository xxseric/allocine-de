<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Acteur', 'doctrine');

/**
 * BaseActeur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $acteur_id
 * @property string $acteur_nom
 * @property string $acteur_prenom
 * @property Doctrine_Collection $ListeActeur
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActeur extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('Acteur');
        $this->hasColumn('acteur_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('acteur_nom', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('acteur_prenom', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('ListeActeur', array(
             'local' => 'acteur_id',
             'foreign' => 'listeActeur_acteur_id'));
    }
}