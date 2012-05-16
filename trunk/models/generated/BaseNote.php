<?php
// Connection Component Binding
Doctrine_Manager::getInstance()->bindComponent('Note', 'doctrine');

/**
 * BaseNote
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $note_id
 * @property integer $film_id
 * @property integer $user_id
 * @property integer $note_val
 * @property string $note_commentaire
 * @property Film $Film
 * @property User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNote extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('note');
        $this->hasColumn('note_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('film_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => false,
             'autoincrement' => false,
             ));
        $this->hasColumn('note_val', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('note_commentaire', 'string', null, array(
             'type' => 'string',
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
        $this->hasOne('Film', array(
             'local' => 'film_id',
             'foreign' => 'film_id'));

        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'user_id'));
    }
}