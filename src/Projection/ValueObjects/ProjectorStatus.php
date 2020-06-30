<?php

namespace srag\CQRS\Projection\ValueObjects;

use Exception;
use srag\CQRS\Aggregate\AbstractValueObject;

/**
 * Class ProjectorStatus
 *
 * @author Theodor Truffer <tt@studer-raimann.ch>
 */
class ProjectorStatus extends AbstractValueObject
{
    const NEW = "new";
    const WORKING = "working";
    const BROKEN = "broken";
    const STALLED = "stalled";
    /**
     * @var string
     */
    private $value;


    /**
     * ProjectorStatus constructor.
     *
     * @param string $value
     *
     * @throws Exception
     */
    public function __construct(string $value)
    {
        if (!in_array($value, [self::NEW, self::WORKING, self::BROKEN, self::STALLED])) {
            throw new Exception("Unknown status of '$value'");
        }
        $this->value = $value;
    }


    /**
     * @param string $value
     *
     * @return bool
     */
    public function is(string $value) : bool
    {
        return $this->value == $value;
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }


    /**
     * @return ProjectorStatus
     * @throws Exception
     */
    public static function new() : ProjectorStatus
    {
        return new self(self::NEW);
    }


    /**
     * @return ProjectorStatus
     * @throws Exception
     */
    public static function working() : ProjectorStatus
    {
        return new self(self::WORKING);
    }


    /**
     * @return ProjectorStatus
     * @throws Exception
     */
    public static function broken() : ProjectorStatus
    {
        return new self(self::BROKEN);
    }


    /**
     * @return ProjectorStatus
     * @throws Exception
     */
    public static function stalled() : ProjectorStatus
    {
        return new self(self::STALLED);
    }
}
