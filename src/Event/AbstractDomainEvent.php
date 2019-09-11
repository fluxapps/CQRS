<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event;

use ilDateTime;
use srag\CQRS\Aggregate\DomainObjectId;

/**
 * Class AbstractDomainEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractDomainEvent implements DomainEvent
{

    /**
     * @var DomainObjectId
     */
    protected $aggregate_id;
    /**
     * @var ilDateTime;
     */
    protected $occurred_on;
    /**
     * @var int
     */
    protected $initiating_user_id;


    /**
     * AbstractDomainEvent constructor.
     *
     * @param DomainObjectId $aggregate_id
     * @param ilDateTime     $occurred_on
     * @param int            $initiating_user_id
     */
    protected function __construct(DomainObjectId $aggregate_id, ilDateTime $occurred_on, int $initiating_user_id)
    {
        $this->aggregate_id = $aggregate_id;
        $this->occurred_on = $occurred_on;
        $this->initiating_user_id = $initiating_user_id;
    }


    /**
     * The Aggregate this event belongs to.
     *
     * @return DomainObjectId
     */
    public function getAggregateId() : DomainObjectId
    {
        return $this->aggregate_id;
    }


    /**
     * @return string
     *
     * Add a Constant EVENT_NAME to your class: Name it: [aggregate].[event]
     * e.g. 'question.created'
     */
    public abstract function getEventName() : string;


    /**
     * @return ilDateTime
     */
    public function getOccurredOn() : ilDateTime
    {
        return $this->occurred_on;
    }


    /**
     * @return int
     */
    public function getInitiatingUserId() : int
    {
        return $this->initiating_user_id;
    }


    /**
     * @return string
     */
    abstract public function getEventBody() : string;


    /**
     * @param string $event_body
     */
    abstract protected function restoreEventBody(string $event_body) : void;


    /**
     * @param DomainObjectId $aggregate_id
     * @param int            $initiating_user_id
     * @param ilDateTime     $occurred_on
     * @param string         $event_body
     *
     * @return mixed
     */
    public static function restore(
        DomainObjectId $aggregate_id,
        int $initiating_user_id,
        ilDateTime $occurred_on,
        string $event_body
    ) : AbstractDomainEvent {
        $restored = new static($aggregate_id, $occurred_on, $initiating_user_id);
        $restored->restoreEventBody($event_body);
        return $restored;
    }
}