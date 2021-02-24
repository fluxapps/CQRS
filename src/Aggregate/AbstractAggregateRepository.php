<?php
/* Copyright (c) 2019 Extended GPL, see docs/LICENSE */

namespace srag\CQRS\Aggregate;

use ILIAS\Data\UUID\Uuid;
use ilGlobalCache;
use srag\CQRS\Event\DomainEvents;
use srag\CQRS\Event\IEventStore;

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
    private $cache;
    /**
     * @var bool
     */
    private $has_cache = false;

    /**
     * AbstractEventSourcedAggregateRepository constructor.
     */
    protected function __construct()
    {
        $this->cache = ilGlobalCache::getInstance(self::CACHE_NAME);
        $this->cache->setActive(true);
        $this->has_cache = $this->cache !== null && $this->cache->isActive();
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
            $this->cache->set($aggregate->getAggregateId()->toString(), $aggregate);
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
        if ($this->has_cache) {
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
        $aggregate = $this->cache->get($cache_key);
        if ($aggregate === null) {
            $aggregate = $this->reconstituteAggregate($this->getEventStore()->getAggregateHistoryFor($aggregate_id));
            $this->cache->set($cache_key, $aggregate);
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
     * @return IEventStore
     */
    abstract protected function getEventStore() : IEventStore;

    /**
     * @param DomainEvents $event_history
     *
     * @return AbstractAggregateRoot
     */
    abstract protected function reconstituteAggregate(DomainEvents $event_history) : AbstractAggregateRoot;

    /**
     * @param Uuid $aggregate_id
     * @return bool
     */
    public function aggregateExists(Uuid $aggregate_id) : bool
    {
        return $this->getEventStore()->aggregateExists($aggregate_id);
    }
}
