<?php

namespace srag\CQRS\Aggregate;

/**
 * Class RevisionId
 *
 * Is a RevisionId where the key has the value name#:#hash where generation of
 * a new key at the factory with the same data and name will generate the same
 * key, so the revisionId allows to validate that the data of the object is
 * valid for that revision
 * 
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
class RevisionId {

	/** @var string */
	private $key;


    /**
     * RevisionId constructor.
     *
     * @param string $key
     */
	public function __construct(string $key) {
		$this->key = $key;
	}


    /**
     * @return string
     */
	public function GetKey(): string {
		return $this->key;
	}
}