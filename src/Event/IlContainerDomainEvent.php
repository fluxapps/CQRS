<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\Libraries\CQRS\Event;

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
interface IlContainerDomainEvent extends DomainEvent {

    /**
     * @return int
     */
    public function getContainerObjId(): int;
}