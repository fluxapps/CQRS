<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Aggregate;

use ILIAS\Data\UUID\Uuid;
use ilGlobalCache;
use srag\CQRS\Event\DomainEvents;
use srag\CQRS\Event\EventStore;

/**
 * Class AbstractAggregateRepository
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractAggregateRepository
{
    const CACHE_NAME = "CQRS_REPOSITORY_CACHE";
    /**
     * @var ilGlobalCache
     */
    private static $cache;
    /**
     * @var bool
     */
    private $has_cache = false;

    /**
     * @var AbstractAggregateRepository
     */
    private static $instances;
    /**
     * @return AbstractAggregateRepository
     */
    public static function getInstance()
    {
        if (self::$instances === null) {
            self::$instances = [];
        }

        $class_name = get_called_class();
        if (!array_key_exists($class_name, self::$instances)) {
            self::$instances[$class_name] = new $class_name();
        }

        return self::$instances[$class_name];
    }

    /**
     * AbstractEventSourcedAggregateRepository constructor.
     */
    protected function __construct()
    {
        if (self::$cache === null) {
            self::$cache = ilGlobalCache::getInstance(self::CACHE_NAME);
            self::$cache->setActive(true);
        }

        $this->has_cache = self::$cache !== null && self::$cache->isActive();
    }


    /**
     * @param AbstractAggregateRoot $aggregate
     */
    public function save(AbstractAggregateRoot $aggregate)
    {
        $events = $aggregate->getRecordedEvents();
        $this->getEventStore()->commit($events);
        $aggregate->clearRecordedEvents();

        if ($this->has_cache) {
            self::$cache->set($aggregate->getAggregateId()->toString(), $aggregate);
        }

        $this->notifyAboutNewEvents();
    }


    /**
     * @param Uuid $aggregate_id
     *
     * @return AbstractAggregateRoot
     */
    public function getAggregateRootById(Uuid $aggregate_id) : AbstractAggregateRoot
    {
        if (false && $this->has_cache) {
            return $this->getFromCache($aggregate_id);
        } else {
            return $this->reconstituteAggregate($this->getEventStore()->getAggregateHistoryFor($aggregate_id));
        }
    }


    /**
     * @param Uuid $aggregate_id
     *
     * @return AbstractAggregateRoot
     */
    private function getFromCache(Uuid $aggregate_id)
    {
        $cache_key = $aggregate_id->toString();
        $aggregate = self::$cache->get($cache_key);
        if ($aggregate === null) {
            $aggregate = $this->reconstituteAggregate($this->getEventStore()->getAggregateHistoryFor($aggregate_id));
            self::$cache->set($cache_key, $aggregate);
        }

        return $aggregate;
    }


    /**
     * Method called to alert known consumers to a new event
     */
    public function notifyAboutNewEvents()
    {
        //Virtual Method
    }

    /**
     * @return EventStore
     */
    abstract protected function getEventStore() : EventStore;


    /**
     * @param DomainEvents $event_history
     *
     * @return AbstractAggregateRoot
     */
    abstract protected function reconstituteAggregate(DomainEvents $event_history) : AbstractAggregateRoot;
}
