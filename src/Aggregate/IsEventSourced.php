<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Aggregate;

use srag\CQRS\Event\DomainEvents;

/**
 * An AggregateRoot, that can be reconstituted from an AggregateHistory.
 */
interface IsEventSourced {

    /**
     * @param DomainEvents $event_history
     *
     * @return AggregateRoot
     */
	public static function reconstitute(DomainEvents $event_history): AggregateRoot;
	
	/**
	 * @return DomainEvents
	 */
	public function getRecordedEvents(): DomainEvents;
	
	/**
	 *
	 */
	public function clearRecordedEvents(): void;
}
 