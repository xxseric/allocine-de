<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Site', 'doctrine');

/**
 * BaseSite
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $site_id
 * @property string $site_lib
 * @property Doctrine_Collection $Film
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSite extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('site');
        $this->hasColumn('site_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('site_lib', 'string', 200, array(
             'type' => 'string',
             'length' => 200,
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
             'local' => 'site_id',
             'foreign' => 'film_site_id'));
    }
}