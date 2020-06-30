<?php

namespace srag\CQRS\Event;

/**
 * Class DomainEventPublisher
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class DomainEventPublisher
{
    protected $subscribers;
    protected static $instance = null;

    /**
     * @return DomainEventPublisher
     */
    public static function getInstance() : DomainEventPublisher
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }
        return static::$instance;
    }


    /**
     * DomainEventPublisher constructor.
     */
    public function __construct()
    {
        $this->subscribers = [];
    }


    /**
     * @param DomainEventSubscriber $aDomainEventSubscriber
     */
    public function subscribe(DomainEventSubscriber $aDomainEventSubscriber) : void
    {
        $this->subscribers[] = $aDomainEventSubscriber;
    }


    /**
     * @param DomainEvent $anEvent
     */
    public function publish(DomainEvent $anEvent) : void
    {
        foreach ($this->subscribers as $aSubscriber) {
            if ($aSubscriber->isSubscribedTo($anEvent)) {
                $aSubscriber->handle($anEvent);
            }
        }
    }
}
