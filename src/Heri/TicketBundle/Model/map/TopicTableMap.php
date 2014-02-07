<?php

namespace Heri\TicketBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'topic' table.
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
class TopicTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Heri.TicketBundle.Model.map.TopicTableMap';

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
        $this->setName('topic');
        $this->setPhpName('Topic');
        $this->setClassname('Heri\\TicketBundle\\Model\\Topic');
        $this->setPackage('src.Heri.TicketBundle.Model');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('label', 'Label', 'VARCHAR', true, 32, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Message', 'Heri\\TicketBundle\\Model\\Message', RelationMap::ONE_TO_MANY, array('id' => 'topic_id', ), null, null, 'Messages');
    } // buildRelations()

} // TopicTableMap
