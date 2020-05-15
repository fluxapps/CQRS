<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event;

use Exception;
use ilDateTime;
use srag\CQRS\Exception\CQRSException;

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
     * @var string
     */
    protected $event_id;
    /**
     * @var string
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
     * @param string $aggregate_id
     * @param ilDateTime     $occurred_on
     * @param int            $initiating_user_id
     */
    protected function __construct(string $aggregate_id, ilDateTime $occurred_on, int $initiating_user_id)
    {
        $this->aggregate_id = $aggregate_id;
        $this->occurred_on = $occurred_on;
        $this->initiating_user_id = $initiating_user_id;
    }


    /**
     * @return string
     */
    public function getEventId() : string
    {
        return $this->event_id;
    }


    /**
     * The Aggregate this event belongs to.
     *
     * @return string
     */
    public function getAggregateId() : string
    {
        return $this->aggregate_id;
    }


    /**
     * @return string
     *
     * Add a Constant EVENT_NAME to your class: Name it: [aggregate].[event]
     * e.g. 'question.created'
     */
    public function getEventName() : string
    {
        return get_called_class();
    }


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
     * @return int
     */
    abstract public static function getEventVersion() : int;

    /**
     * @param string        $event_id
     * @param string $aggregate_id
     * @param int            $initiating_user_id
     * @param ilDateTime     $occurred_on
     * @param string         $event_body
     *
     * @return mixed
     * @throws Exception
     */
    public static function restore(
        string $event_id,
        int $event_version,
        string $aggregate_id,
        int $initiating_user_id,
        ilDateTime $occurred_on,
        string $event_body
    ) : AbstractDomainEvent {
        $restored = new static($aggregate_id, $occurred_on, $initiating_user_id);
        $restored->event_id = $event_id;

        if (static::getEventVersion() < $event_version)
        {
            throw new CQRSException('Event store contains future versions of Events, ILIAS update necessary');
        }

        $restored->processEventBody($event_body, $event_version);

        return $restored;
    }

    /**
     * @param string $event_body
     * @param int $event_version
     */
    private function processEventBody(string $event_body, int $event_version)
    {
        if (static::getEventVersion() === $event_version) {
            $this->restoreEventBody($event_body);
        }
        else {
            $this->restoreOldEventBody($event_body, $event_version);
        }
    }

    /**
     * @param string $event_body
     */
    abstract protected function restoreEventBody(string $event_body) : void;

    /**
     * @return DomainEvent
     */
    protected function restoreOldEventBody(string $old_event_body, int $old_version) : DomainEvent {
        throw new CQRSException("Used ILIAS not compatible with available EventStore");
    }
}