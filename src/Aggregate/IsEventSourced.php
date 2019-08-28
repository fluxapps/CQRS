<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\Libraries\CQRS\Aggregate;

use srag\Libraries\CQRS\Event\DomainEvents;

/**
 * An AggregateRoot, that can be reconstituted from an AggregateHistory.
 */
interface IsEventSourced {

	public static function reconstitute(DomainEvents $event_history): AggregateRoot;
}
 