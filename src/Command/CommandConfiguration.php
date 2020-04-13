<?php

namespace srag\CQRS\Command;

use srag\CQRS\Command\Access\CommandAccessContract;

/**
 * Class CommandConfiguration
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class CommandConfiguration {
    /**
     * @var string
     */
    private $class;
    
    /**
     * @var CommandHandlerContract
     */
    private $handler;
    
    /**
     * @var CommandAccessContract
     */
    private $access;
    
    /**
     * @param string $class
     * @param CommandHandlerContract $handler
     * @param CommandAccessContract $access
     */
    public function __construct(string $class, CommandHandlerContract $handler, CommandAccessContract $access) {
        $this->class = $class;
        $this->handler = $handler;
        $this->access = $access;
    }
    
    /**
     * @return string
     */
    public function getClass() : string {
        return $this->class;
    }
    
    /**
     * @return CommandHandlerContract
     */
    public function getHandler() : CommandHandlerContract {
        return $this->handler;
    }
    
    /**
     * @return CommandAccessContract
     */
    public function getAccess() : CommandAccessContract {
        return $this->access;
    }
}