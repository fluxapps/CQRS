<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event\Standard;

use srag\CQRS\Event\AbstractDomainEvent;
use srag\CQRS\Aggregate\AbstractValueObject;
use ILIAS\Data\UUID\Uuid;
use ilDateTime;

/**
 * Class AggregateCreatedEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class AggregateCreatedEvent extends AbstractDomainEvent
{

    /**
     * @var array
     */
    protected $additional_data;

    /**
     * @param Uuid $aggregate_id
     * @param ilDateTime $occurred_on
     * @param int $initiating_user_id
     * @param array $additional_aata
     */
    public function __construct(Uuid $aggregate_id, ilDateTime $occurred_on, int $initiating_user_id, array $additional_aata = null)
    {
        $this->additional_data = $additional_aata;

        parent::__construct($aggregate_id, $occurred_on, $initiating_user_id);
    }

    /**
     * @return array
     */
    public function getAdditionalData() : array
    {
        return $this->additional_data;
    }

    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Event\AbstractDomainEvent::getEventBody()
     */
    public function getEventBody() : string
    {
        return json_encode($this->additional_data);
    }

    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Event\AbstractDomainEvent::restoreEventBody()
     */
    protected function restoreEventBody(string $event_body) : void
    {
        $this->additional_data = AbstractValueObject::deserialize($event_body);
    }

    /**
     * @return int
     */
    public static function getEventVersion() : int
    {
        // initial version 1
        return 1;
    }
}
