<?php

namespace srag\CQRS\Projection;

use Exception;
use ilException;
use ilLogger;
use srag\CQRS\Event\EventStore;
use srag\CQRS\Projection\ValueObjects\ProjectorPosition;

/**
 * Class Projectionist
 *
 * @package srag\CQRS\Projection
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class Projectionist
{

    /**
     * @var PositionLedger
     */
    protected $position_ledger;
    /**
     * @var EventStore
     */
    protected $event_store;
    /**
     * @var ilLogger
     */
    protected $error_logger;


    /**
     * Projectionist constructor.
     *
     * @param PositionLedger $position_ledger
     * @param EventStore     $event_store
     * @param ilLogger       $error_logger
     */
    public function __construct(PositionLedger $position_ledger, EventStore $event_store, ilLogger $error_logger)
    {
        $this->position_ledger = $position_ledger;
        $this->event_store = $event_store;
        $this->error_logger = $error_logger;
    }


    /**
     * @param ProjectorCollection $projector_collection
     *
     * @throws Exception
     */
    public function playProjectors(ProjectorCollection $projector_collection) : void
    {
        $exceptions = [];
        $event_handler = new ProjectionEventHandler();
        foreach ($projector_collection->all() as $projector) {
            $position = $this->position_ledger->fetch($projector) ?: ProjectorPosition::makeNewUnplayed($projector);
            if ($position->isFailing()) {
                continue;
            }
            try {
                foreach ($this->event_store->getEventStream($position->last_position)->getEvents() as $event) {
                    $event_handler->handle($event, $projector);
                    $position = $position->played($event);
                }
            } catch (Exception $e) {
                $this->error_logger->error($e->getMessage());
                $this->error_logger->error($e->getTraceAsString());
                $position = $position->broken();
                $exceptions[] = $e;
            }
            $this->position_ledger->store($position);
        }
        if (count($exceptions) > 0) {
            throw new ilException(count($exceptions) . ' projector(s) failed. See Error Log for details.');
        }
    }
}
