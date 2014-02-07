<?php

namespace Heri\TicketBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'user' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Heri.TicketBundle.Model.map
 */
class UserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Heri.TicketBundle.Model.map.UserTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('user');
        $this->setPhpName('User');
        $this->setClassname('Heri\\TicketBundle\\Model\\User');
        $this->setPackage('src.Heri.TicketBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 50, null);
        $this->getColumn('username', false)->setPrimaryString(true);
        $this->addColumn('firstname', 'Firstname', 'VARCHAR', false, 50, null);
        $this->addColumn('lastname', 'Lastname', 'VARCHAR', false, 50, null);
        $this->addColumn('fullname', 'Fullname', 'VARCHAR', false, 100, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 50, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', false, 1, null);
        $this->addColumn('salt', 'Salt', 'VARCHAR', true, 255, null);
        $this->addColumn('password', 'Password', 'VARCHAR', true, 255, null);
        $this->addColumn('last_login', 'LastLogin', 'TIMESTAMP', false, null, null);
        $this->addColumn('locked', 'Locked', 'BOOLEAN', false, 1, null);
        $this->addColumn('expired', 'Expired', 'BOOLEAN', false, 1, null);
        $this->addColumn('expires_at', 'ExpiresAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('roles', 'Roles', 'ARRAY', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Message', 'Heri\\TicketBundle\\Model\\Message', RelationMap::ONE_TO_MANY, array('id' => 'assigned_user_id', ), null, null, 'Messages');
        $this->addRelation('Response', 'Heri\\TicketBundle\\Model\\Response', RelationMap::ONE_TO_MANY, array('id' => 'user_id', ), null, null, 'Responses');
    } // buildRelations()

} // UserTableMap
