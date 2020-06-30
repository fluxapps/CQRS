<?php

namespace srag\CQRS\Command;

use DomainException;
use ILIAS\Data\Result;
use ILIAS\Data\Result\Error;
use srag\CQRS\Exception\CQRSException;

/**
 * Class CommandBus
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class CommandBus implements CommandBusContract
{

    /**
     *  @var array
     */
    private $middlewares;

    /**
     * @var string[]
     */
    private $command_handler_map;

    public function __construct()
    {
        $this->middlewares = [];
    }


    /**
     * @param CommandContract $command
     *
     */
    public function handle(CommandContract $command) : Result
    {
        $class = get_class($command);
        
        if (!array_key_exists($class, $this->command_handler_map)) {
            return new Error(new CQRSException(sprintf('No handler defined for command: %s', $class)));
        }
        
        /** @var $config CommandConfiguration */
        $config = $this->command_handler_map[$class];
        
        foreach ($this->middlewares as $middleware) {
            $command = $middleware->handle($command);
        }

        if (!$config->getAccess()->canIssueCommand($command)) {
            return new Error(new CQRSException('Access Denied'));
        }

        return $config->getHandler()->handle($command);
    }


    /**
     * Appends new middleware for this message bus.
     * Should only be used at configuration time.
     *
     * @param CommandHandlerMiddleware $middleware
     *
     * @return void
     */
    public function appendMiddleware(CommandHandlerMiddleware $middleware) : void
    {
        $this->middlewares[] = $middleware;
    }
    
    /**
     * @param CommandHandlerContract $handler
     * @param string $command_class
     */
    public function registerCommand(CommandConfiguration $config)
    {
        $this->command_handler_map[$config->getClass()] = $config;
    }
}
