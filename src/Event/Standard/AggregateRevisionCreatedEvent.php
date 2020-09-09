<?php
declare(strict_types=1);

namespace srag\CQRS\Event\Standard;

use ilDateTime;
use srag\CQRS\Aggregate\RevisionId;
use srag\CQRS\Event\AbstractDomainEvent;
use ILIAS\Data\UUID\Uuid;

/**
 * Class AggregateRevisionCreatedEvent
 *
 * @license Extended GPL, see docs/LICENSE
 * @copyright 1998-2020 ILIAS open source
 *
 * @package srag/asq
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 */
class AggregateRevisionCreatedEvent extends AbstractDomainEvent
{
    /**
     * @var RevisionId
     */
    public $revision_id;

    /**
     * Revision Created event constructor
     *
     * @param Uuid $aggregate_id
     * @param ilDateTime $occurred_on
     * @param int $initiating_user_id
     * @param RevisionId $revision_id
     */
    public function __construct(Uuid $aggregate_id, ilDateTime $occurred_on, int $initiating_user_id, RevisionId $revision_id = null)
    {
        $this->revision_id = $revision_id;

        parent::__construct($aggregate_id, $occurred_on, $initiating_user_id);
    }

    /**
     * @return string
     */
    public function getRevisionId() : RevisionId
    {
        return $this->revision_id;
    }

    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Event\AbstractDomainEvent::getEventBody()
     */
    public function getEventBody() : string
    {
        return json_encode($this->revision_id);
    }

    /**
     * @param string $json_data
     */
    public function restoreEventBody(string $json_data) : void
    {
        $this->revision_id = RevisionId::deserialize($json_data);
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
