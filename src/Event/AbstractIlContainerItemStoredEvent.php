<?php

namespace srag\CQRS\Event;

use ilDateTime;
use srag\CQRS\Aggregate\DomainObjectId;
use srag\CQRS\CQRS\Event\AbstractStoredEvent;

/**
 * Class AbstractIlContainerItemStoredEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractIlContainerItemStoredEvent extends AbstractStoredEvent
{
    /**
     * @var int
     *
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_length     8
     */
    protected $item_id;
    
    /**
     * Store event data.
     *
     * @param DomainObjectId $aggregate_id
     * @param string         $event_name
     * @param ilDateTime     $occurred_on
     * @param int            $item_id
     * @param int            $initiating_user_id
     * @param string         $event_body
     */
    public function setEventData(DomainObjectId $aggregate_id, string $event_name, ilDateTime $occurred_on, int $item_id, int $container_obj_id, int $initiating_user_id, string $event_body)
    {
        $this->item_id = $item_id;
        
        parent::setEventData($aggregate_id, $event_name, $occurred_on, $container_obj_id, $initiating_user_id, $event_body);
    }
    
    /**
     * @return int
     */
    public function getItemId() {
        return $this->item_id;
    }
}