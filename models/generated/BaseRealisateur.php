<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Realisateur', 'doctrine');

/**
 * BaseRealisateur
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $realisateur_id
 * @property string $realisateur_nom
 * @property string $realisateur_prenom
 * @property Doctrine_Collection $Film
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseRealisateur extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('realisateur');
        $this->hasColumn('realisateur_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('realisateur_nom', 'string', 80, array(
             'type' => 'string',
             'length' => 80,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('realisateur_prenom', 'string', 80, array(
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
        $this->hasMany('Film', array(
             'local' => 'realisateur_id',
             'foreign' => 'film_realisateur_id'));
    }
}