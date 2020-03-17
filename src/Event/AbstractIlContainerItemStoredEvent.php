<?php

namespace srag\CQRS\Event;

use ilDateTime;
use srag\CQRS\Aggregate\DomainObjectId;

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
     * @var int
     *
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_length     8
     */
    protected $container_id;

    /**
     * Store event data.
     *
     * @param EventID $event_id
     * @param DomainObjectId $aggregate_id
     * @param int $item_id
     * @param int $container_id
     * @param string $event_name
     * @param ilDateTime $occurred_on
     * @param int $initiating_user_id
     * @param string $event_body
     * @param string $event_class
     */
    public function setCIEventData(EventID $event_id, 
                                   DomainObjectId $aggregate_id, 
                                   int $item_id, 
                                   int $container_id, 
                                   string $event_name, 
                                   ilDateTime $occurred_on, 
                                   int $initiating_user_id, 
                                   string $event_body, 
                                   string $event_class): void
    {
        $this->item_id = $item_id;
        $this->container_id = $container_id;

        parent::setEventData($event_id, $aggregate_id, $event_name, $occurred_on, $initiating_user_id, $event_body, $event_class);
    }
    
    /**
     * @return int
     */
    public function getItemId() {
        return $this->item_id;
    }
    
    public function getContainerId() {
        return $this->container_id;
    }
}