<?php

namespace srag\CQRS\Aggregate;

/**
 * Class DomainObjectId
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class DomainObjectId
{

    /**
     * @var string
     */
    private $id;


    /**
     * DomainObjectId constructor.
     *
     * @param string|null $id
     *
     * @throws \Exception
     */
    public function __construct(string $id = null)
    {
        $this->id = $id ?: Guid::create();
    }


    /**
     * @return string
     */
    public function getId() : string
    {
        return $this->id;
    }


    /**
     * @param DomainObjectId $anId
     *
     * @return bool
     */
    public function equals(DomainObjectId $anId) : bool
    {
        return $this->getId() === $anId->getId();
    }
}