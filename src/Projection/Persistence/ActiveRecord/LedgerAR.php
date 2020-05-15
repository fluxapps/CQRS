<?php

namespace srag\CQRS\Projection\Persistence\ActiveRecord;

use ActiveRecord;
use Exception;
use ilDateTime;
use ilDateTimeException;
use srag\CQRS\Projection\ValueObjects\ProjectorStatus;

/**
 * Class LedgerAR
 *
 * @author Theodor Truffer <tt@studer-raimann.ch>
 */
class LedgerAR extends ActiveRecord
{

    const TABLE_NAME = 'sr_projection_ledger';


    /**
     * @return string
     */
    public function getConnectorContainerName()
    {
        return self::TABLE_NAME;
    }


    /**
     * @var string
     *
     * @con_is_primary true
     * @con_has_field  true
     * @con_fieldtype  text
     * @con_length     200
     */
    public $projector_class;
    /**
     * @var int
     *
     * @con_has_field  true
     * @con_fieldtype  integer
     * @con_is_notnull true
     * @con_length     8
     */
    public $processed_events;
    /**
     * @var string
     *
     * @con_has_field  true
     * @con_fieldtype  text
     * @con_length     200
     */
    public $last_position;
    /**
     * @var ilDateTime
     *
     * @con_has_field  true
     * @con_fieldtype  timestamp
     */
    public $occurred_at;
    /**
     * @var ProjectorStatus
     *
     * @con_has_field  true
     * @con_fieldtype  text
     * @con_is_notnull true
     * @con_length     200
     */
    public $status;


    /**
     * @param $field_name
     *
     * @return int|mixed|string|null
     */
    public function sleep($field_name)
    {
        switch ($field_name) {
            case 'last_position':
                return $this->last_position ? $this->last_position->getId() : null;
            case 'occurred_at':
                return $this->occurred_at ? $this->occurred_at->get('Y-m-d') : null;
            case 'status':
                return $this->status ? $this->status->__toString() : null;
            default:
                return null;
        }
    }


    /**
     * @param $field_name
     * @param $field_value
     *
     * @return ilDateTime|mixed|string|ProjectorStatus|null
     * @throws ilDateTimeException
     * @throws Exception
     */
    public function wakeUp($field_name, $field_value)
    {
        switch ($field_name) {
            case 'occurred_at':
                return $field_value ? new ilDateTime($field_value) : null;
            case 'status':
                return new ProjectorStatus($field_value);
            default:
                return null;
        }
    }
}