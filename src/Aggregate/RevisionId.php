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
class RevisionId extends AbstractValueObject
{

    /** @var string */
    protected $key;

    /** @var string */
    protected $algorithm;
    
    /** @var string */
    protected $name;

    /**
     * RevisionId generator function.
     *
     * @param string $key
     * @param string $algorithm
     * @param string $name
     */
    public static function create(string $key, string $algorithm, string $name)
    {
        $revision_id = new RevisionId();
        $revision_id->key = $key;
        $revision_id->algorithm = $algorithm;
        $revision_id->name = $name;
        return $revision_id;
    }

    /**
     * @return string
     */
    public function GetKey() : string
    {
        return $this->key;
    }
    
    /**
     * @return string
     */
    public function getAlgorithm() : string
    {
        return $this->algorithm;
    }
    
    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }
}
