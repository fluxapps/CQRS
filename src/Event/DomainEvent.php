<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event;

use \ilDateTime;

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
interface DomainEvent
{

    /**
     * @return string
     */
    public function getEventId() : string;

    /**
     * The Aggregate this event belongs to.
     *
     * @return string
     */
    public function getAggregateId() : string;

    /**
     * @return string
     */
    public function getEventName() : string;

    /**
     * @return ilDateTime
     */
    public function getOccurredOn() : ilDateTime;


    /**
     * @return int
     */
    public function getInitiatingUserId() : int;


    /**
     * @return string
     */
    public function getEventBody() : string;
}
