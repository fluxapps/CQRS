<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event;

use ilDateTime;
use srag\CQRS\Aggregate\DomainObjectId;

/**
 * Class AbstractIlContainerItemDomainEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractIlContainerItemDomainEvent extends AbstractDomainEvent
{
    /**
     * @var int
     */
    protected $item_id;
    
    /**
     * @var int
     */
    protected $container_id;
    
    /**
     * @param DomainObjectId $aggregate_id
     * @param int $item_id
     * @param int $container_obj_id
     * @param int $initiating_user_id
     */
    public function __construct(DomainObjectId $aggregate_id, int $item_id, int $container_obj_id, int $initiating_user_id)
    {
        
        $this->item_id = $item_id;
        $this->container_id = $container_obj_id;
        
        parent::__construct($aggregate_id, new ilDateTime(), $initiating_user_id);
    }
    
    public function getItemId() {
        return $this->item_id;
    }
    
    public function getContainerId() {
        return $this->container_id;
    }
    
    public static function ciRestore(
        EventID $event_id, 
        DomainObjectId $aggregate_id, 
        int $initiating_user_id, 
        ilDateTime $occurred_on,
        int $container_id,
        int $item_id,
        string $event_body): AbstractDomainEvent
    {
        $restored = new static($aggregate_id, $item_id, $container_id, $occurred_on, $initiating_user_id);
        $restored->event_id = $event_id;
        $restored->restoreEventBody($event_body);
        return $restored;
    }
}