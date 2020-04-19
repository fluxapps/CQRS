<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event\Standard;

use srag\CQRS\Event\AbstractDomainEvent;
use ilDateTime;
use srag\CQRS\Aggregate\DomainObjectId;

/**
 * Class AggregateDeletedEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class AggregateDeletedEvent extends AbstractDomainEvent {
    /**
     * @param DomainObjectId $aggregate_id
     * @param ilDateTime $occurred_on
     * @param int $initiating_user_id
     */
    public function __construct(DomainObjectId $aggregate_id, ilDateTime $occurred_on, int $initiating_user_id) {
        parent::__construct($aggregate_id, $occurred_on, $initiating_user_id);
    }
    
    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Event\AbstractDomainEvent::getEventBody()
     */
    public function getEventBody(): string
    {
        //no additional parameters
        return '';
    }
    
    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Event\AbstractDomainEvent::restoreEventBody()
     */
    protected function restoreEventBody(string $event_body): void
    {
        //no additional parameters
    }
    
    /**
     * @return int
     */
    public static function getEventVersion(): int
    {
        // initial version 1
        return 1;
    }
}