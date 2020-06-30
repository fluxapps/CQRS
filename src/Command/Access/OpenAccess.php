<?php

namespace srag\CQRS\Command\Access;

use srag\CQRS\Command\CommandContract;

/**
 * Class OpenAccess
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class OpenAccess implements CommandAccessContract
{
    /**
     * {@inheritDoc}
     * @see \srag\CQRS\Command\Access\CommandAccessContract::canIssueCommand()
     */
    public function canIssueCommand(CommandContract $command) : bool
    {
        return true;
    }
}
