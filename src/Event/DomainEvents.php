<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\Libraries\CQRS\Event;

/**
 * Class DomainEvents
 *
 * List of domain events
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class DomainEvents {

	/**
	 * @var array
	 */
	private $events;


	/**
	 * DomainEvents constructor.
	 */
	public function __construct() {
		$this->events = [];
	}


	/**
	 * @param DomainEvent $event
	 */
	public function addEvent(DomainEvent $event) {
		$this->events[] = $event;
	}


	/**
	 * @return array
	 */
	public function getEvents(): array {
		return $this->events;
	}
}