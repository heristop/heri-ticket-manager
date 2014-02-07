<?php

namespace Heri\TicketBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'message' table.
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
class MessageTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Heri.TicketBundle.Model.map.MessageTableMap';

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
        $this->setName('message');
        $this->setPhpName('Message');
        $this->setClassname('Heri\\TicketBundle\\Model\\Message');
        $this->setPackage('src.Heri.TicketBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('topic_id', 'MessageId', 'INTEGER', 'topic', 'id', false, null, null);
        $this->addForeignKey('priority_id', 'PriorityId', 'INTEGER', 'priority', 'id', false, null, null);
        $this->addForeignKey('assigned_user_id', 'AssignedUserId', 'INTEGER', 'user', 'id', false, null, null);
        $this->addColumn('username', 'Username', 'VARCHAR', true, 32, null);
        $this->addColumn('subject', 'Subject', 'VARCHAR', true, 64, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 50, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 32, null);
        $this->addColumn('header_mail', 'HeaderMail', 'LONGVARCHAR', false, null, null);
        $this->addColumn('body', 'Body', 'LONGVARCHAR', false, null, null);
        $this->addColumn('ip_address', 'IpAddress', 'VARCHAR', false, 16, null);
        $this->addColumn('status', 'Status', 'VARCHAR', true, 16, 'opened');
        $this->addColumn('source', 'Source', 'VARCHAR', false, 16, null);
        $this->addColumn('overdue_date', 'OverdueDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('last_response_date', 'LastResponseDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('creation_date', 'CreationDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('modification_date', 'ModificationDate', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Topic', 'Heri\\TicketBundle\\Model\\Topic', RelationMap::MANY_TO_ONE, array('topic_id' => 'id', ), null, null);
        $this->addRelation('Priority', 'Heri\\TicketBundle\\Model\\Priority', RelationMap::MANY_TO_ONE, array('priority_id' => 'id', ), null, null);
        $this->addRelation('User', 'Heri\\TicketBundle\\Model\\User', RelationMap::MANY_TO_ONE, array('assigned_user_id' => 'id', ), null, null);
        $this->addRelation('Response', 'Heri\\TicketBundle\\Model\\Response', RelationMap::ONE_TO_MANY, array('id' => 'message_id', ), null, null, 'Responses');
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
            'timestampable' =>  array (
  'create_column' => 'creation_date',
  'update_column' => 'modification_date',
  'disable_updated_at' => 'false',
),
            'senchagridable' =>  array (
),
        );
    } // getBehaviors()

} // MessageTableMap
