<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\Libraries\CQRS\Event;

use \ilDateTime;
use srag\Libraries\CQRS\Aggregate\DomainObjectId;

/**
 * Interface DomainEvent
 *
 * Something that happened in the past, that is of importance to the business.
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
interface DomainEvent {

	/**
	 * The Aggregate this event belongs to.
	 *
	 * @return DomainObjectId
	 */
	public function getAggregateId(): DomainObjectId;


	/**
	 * @return string
	 */
	public function getEventName(): string;


	/**
	 * @return ilDateTime
	 */
	public function getOccurredOn(): ilDateTime;


	/**
	 * @return int
	 */
	public function getInitiatingUserId(): int;


	/**
	 * @return string
	 */
	public function getEventBody(): string;
}