<?php

namespace srag\CQRS\Projection;

use srag\CQRS\Event\DomainEvent;

/**
 * Class ProjectionEventHandler
 *
 * @package srag\CQRS\Projection
 *
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class ProjectionEventHandler
{

    /**
     * @param $event
     * @param $projector
     */
    public function handle(DomainEvent $event, Projector $projector)
    {
        $method = $this->handlerFunctionName($event->getEventName());
        if (method_exists($projector, $method)) {
            $projector->$method($event);
        }
    }


    /**
     * @param string $type
     *
     * @return string
     */
    private function handlerFunctionName(string $type) : string
    {
        return "when" . $type;
    }
}
