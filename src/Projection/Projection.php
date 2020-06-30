<?php

namespace srag\CQRS\Projection;

use ilDBInterface;

/**
 * Class Projection
 *
 * @author Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class Projection
{

    /**
     * @var ilDBInterface
     */
    protected $database;


    public function __construct(ilDBInterface $database)
    {
        $this->database = $database;
    }
}
