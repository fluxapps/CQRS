<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event;

use ILIAS\Data\UUID\Uuid;

/**
 * Interface IEventStore
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
interface IEventStore
{
    /**
     * @param DomainEvents $events
     *
     * @return void
     */
    public function commit(DomainEvents $events) : void;

    /**
     * @param Uuid $id
     * @return bool
     */
    public function aggregateExists(Uuid $id) : bool;

    /**
     * @param Uuid $id
     *
     * @return DomainEvents
     */
    public function getAggregateHistoryFor(Uuid $id) : DomainEvents;

    /**
     * @param ?string $from_id
     *
     * @return DomainEvents
     */
    public function getEventStream(?string $from_id = null) : DomainEvents;
}