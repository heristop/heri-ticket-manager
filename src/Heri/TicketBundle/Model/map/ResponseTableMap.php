<?php

namespace Heri\TicketBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'response' table.
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
class ResponseTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Heri.TicketBundle.Model.map.ResponseTableMap';

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
        $this->setName('response');
        $this->setPhpName('Response');
        $this->setClassname('Heri\\TicketBundle\\Model\\Response');
        $this->setPackage('src.Heri.TicketBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('message_id', 'MessageId', 'INTEGER', 'message', 'id', true, null, null);
        $this->addForeignKey('user_id', 'UserId', 'INTEGER', 'user', 'id', true, null, null);
        $this->addColumn('body', 'Body', 'LONGVARCHAR', false, null, null);
        $this->addColumn('ip_address', 'IpAddress', 'VARCHAR', false, 16, null);
        $this->addColumn('creation_date', 'CreationDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('modification_date', 'ModificationDate', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Message', 'Heri\\TicketBundle\\Model\\Message', RelationMap::MANY_TO_ONE, array('message_id' => 'id', ), null, null);
        $this->addRelation('User', 'Heri\\TicketBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('user_id' => 'id', ), null, null);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'senchagridable' =>  array (
),
        );
    } // getBehaviors()

} // ResponseTableMap
