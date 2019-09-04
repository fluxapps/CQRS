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
abstract class AbstractDomainEvent implements DomainEvent {

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
	 * The Aggregate this event belongs to.
	 *
	 * @return DomainObjectId
	 */
	public function getAggregateId(): DomainObjectId {
		return $this->aggregate_id;
	}


	/**
	 * @return string
	 *
	 * Add a Constant EVENT_NAME to your class: Name it: [aggregate].[event]
	 * e.g. 'question.created'
	 */
	public abstract function getEventName(): string;


	/**
	 * @return ilDateTime
	 */
	public function getOccurredOn(): ilDateTime {
		return $this->occurred_on;
	}


	/**
	 * @return int
	 */
	public function getInitiatingUserId(): int {
		return $this->initiating_user_id;

	}


	/**
	 * @return string
	 */
	public function getEventBody(): string {
		return json_encode($this);
	}


    /**
     * @param DomainObjectId $aggregate_id
     * @param int            $initiating_user_id
     * @param ilDateTime     $occurred_on
     * @param string         $event_body
     *
     * @return mixed
     */
    abstract public static function restore(
        DomainObjectId $aggregate_id,
        int $initiating_user_id,
        ilDateTime $occurred_on,
        string $event_body
    ) : AbstractDomainEvent;

}