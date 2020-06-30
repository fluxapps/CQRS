<?php

namespace srag\CQRS\Projection\ValueObjects;

use Exception;
use ilDateTime;
use srag\CQRS\Aggregate\AbstractValueObject;
use srag\CQRS\Event\DomainEvent;
use srag\CQRS\Projection\Projector;

/**
 * Class ProjectorPosition
 *
 * @package srag\CQRS\Projection\ValueObjects
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ProjectorPosition extends AbstractValueObject
{

    /**
     * @var Projector
     */
    public $projector;
    /**
     * @var int
     */
    public $processed_events;
    /**
     * @var string
     */
    public $last_position;
    /**
     * @var ilDateTime
     */
    public $occurred_at;
    /**
     * @var ProjectorStatus
     */
    public $status;


    /**
     * ProjectorPosition constructor.
     *
     * @param Projector       $projector
     * @param int             $processed_events
     * @param ilDateTime|null $occurred_at
     * @param string          $last_position
     * @param ProjectorStatus $status
     */
    public function __construct(
        Projector $projector,
        int $processed_events,
        ?ilDateTime $occurred_at,
        ?string $last_position,
        ProjectorStatus $status
    ) {
        $this->projector = $projector;
        $this->processed_events = $processed_events;
        $this->last_position = $last_position;
        $this->occurred_at = $occurred_at;
        $this->status = $status;
    }


    /**
     * @param Projector $projector
     *
     * @return ProjectorPosition
     * @throws Exception
     */
    public static function makeNewUnplayed(Projector $projector) : ProjectorPosition
    {
        return new ProjectorPosition(
            $projector,
            0,
            null,
            null,
            ProjectorStatus::new()
        );
    }


    /**
     * @param DomainEvent $event
     *
     * @return ProjectorPosition
     * @throws Exception
     */
    public function played(DomainEvent $event) : ProjectorPosition
    {
        $event_count = $this->processed_events + 1;

        return new ProjectorPosition(
            $this->projector,
            $event_count,
            new ilDateTime(time(), IL_CAL_UNIX),
            $event->getEventId(),
            ProjectorStatus::working()
        );
    }


    /**
     * @return ProjectorPosition
     * @throws Exception
     */
    public function broken() : ProjectorPosition
    {
        return new ProjectorPosition(
            $this->projector,
            $this->processed_events,
            new ilDateTime(time(), IL_CAL_UNIX),
            $this->last_position,
            ProjectorStatus::broken()
        );
    }


    /**
     * @return ProjectorPosition
     * @throws Exception
     */
    public function stalled() : ProjectorPosition
    {
        return new ProjectorPosition(
            $this->projector,
            $this->processed_events,
            new ilDateTime(time(), IL_CAL_UNIX),
            $this->last_position,
            ProjectorStatus::stalled()
        );
    }


    /**
     * @param Projector $current_projector
     *
     * @return mixed
     */
    public function isSame(Projector $current_projector)
    {
        return $this->projector->equals($current_projector);
    }


    /**
     * @return bool
     */
    public function isFailing()
    {
        return $this->status->is(ProjectorStatus::BROKEN) || $this->status->is(ProjectorStatus::STALLED);
    }
}
