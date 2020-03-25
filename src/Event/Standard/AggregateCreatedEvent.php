<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Event\Standard;

use srag\CQRS\Event\AbstractDomainEvent;
use function GuzzleHttp\json_decode;

/**
 * Class AggregateCreatedEvent
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class AggregateCreatedEvent extends AbstractDomainEvent {
    
    /**
     * @var array
     */
    protected  $additional_data;
    
    public function __construct($aggregate_id, $occurred_on, $initiating_user_id, array $additional_aata = null) {
        $this->additional_data = $additional_aata;
        
        parent::__construct($aggregate_id, $occurred_on, $initiating_user_id);
    }
    
    public function getAdditionalData() : array {
        return $this->additional_data;
    }
    
    public function getEventBody(): string
    {
        return json_encode($this->additional_data);
    }

    protected function restoreEventBody(string $event_body): void
    {
        $this->additional_data = json_decode($event_body, true);
    }
}