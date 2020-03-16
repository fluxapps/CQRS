<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Aggregate;

use srag\CQRS\Event\DomainEvent;
use srag\CQRS\Event\DomainEvents;
use srag\CQRS\Event\Standard\AggregateCreatedEvent;
use srag\CQRS\Exception\CQRSException;
use srag\CQRS\Event\Standard\AggregateDeletedEvent;

/**
 * Class AbstractEventSourcedAggregateRoot
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractEventSourcedAggregateRoot implements AggregateRoot, RecordsEvents, IsEventSourced {

	const APPLY_PREFIX = 'apply';
	
	/**
	 * @var DomainObjectId
	 */
	private $aggregate_id;
	
	/**
	 * @var DomainEvents
	 */
	private $recordedEvents;

	/**
	 * @var bool
	 */
    private $is_deleted;
	
    /**
     * AbstractEventSourcedAggregateRoot constructor.
     */
    protected function __construct() {
		$this->recordedEvents = new DomainEvents();
	}


    /**
     * @param DomainEvent $event
     */
    protected function ExecuteEvent(DomainEvent $event) {
        if ($this->is_deleted) {
            return new CQRSException("Action on deleted Aggregate not allowed");
        }
        
		// apply results of event to class, most events should result in some changes
		$this->applyEvent($event);

		// always record that the event has happened
		$this->recordEvent($event);
	}


    /**
     * @param DomainEvent $event
     */
    protected function recordEvent(DomainEvent $event) {
		$this->recordedEvents->addEvent($event);
	}


    /**
     * @param DomainEvent $event
     */
    protected function applyEvent(DomainEvent $event) {
		$action_handler = $this->getHandlerName($event);

		if (method_exists($this, $action_handler)) {
			$this->$action_handler($event);
		}
	}

	/**
	 * @param AggregateCreatedEvent $event
	 */
	protected function applyAggregateCreatedEvent(DomainEvent $event) {
	    $this->aggregate_id = $event->getAggregateId();
	}
	
	/**
	 * @param AggregateDeletedEvent $event
	 */
	protected function appliAggregateDeletedEvent(DomainEvent $event) {
	    $this->is_deleted = true;
	}

    /**
     * @param DomainEvent $event
     *
     * @return string
     */private function getHandlerName(DomainEvent $event) {
		return self::APPLY_PREFIX . join('', array_slice(explode('\\', get_class($event)), - 1));
	}


	/**
	 * @return DomainEvents
	 */
	public function getRecordedEvents(): DomainEvents {
		return $this->recordedEvents;
	}


    /**
     *
     */
    public function clearRecordedEvents(): void {
		$this->recordedEvents = new DomainEvents();
	}


    /**
     * @return DomainObjectId
     */
	function getAggregateId(): DomainObjectId {
	    return $this->aggregate_id;
	}

    /**
     * @param DomainEvents $event_history
     *
     * @return AggregateRoot
     */
    public static function reconstitute(DomainEvents $event_history) : AggregateRoot
    {
        $aggregate_root = new static();
        foreach ($event_history->getEvents() as $event) {
            $aggregate_root->applyEvent($event);
        }

        return $aggregate_root;
    }
}