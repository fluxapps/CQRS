<?php

namespace srag\CQRS\Aggregate;

/**
 * Interface IsRevisable
 *
 * Generates Revision safe Revision id for IsRevisable object
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
interface IsRevisable
{
    /**
     * @return RevisionId revision id of object
     */
    public function getRevisionId() : ?RevisionId;

    /**
     * @param RevisionId $id
     */
    public function setRevisionId(RevisionId $id, int $user_id);
}
