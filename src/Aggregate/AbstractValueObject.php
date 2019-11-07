<?php

namespace srag\CQRS\Aggregate;

use ilDate;
use ilDateTime;
use JsonSerializable;
use stdClass;

/**
 * Class AbstractValueObject
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author  Adrian Lüthi <al@studer-raimann.ch>
 * @author  Björn Heyser <bh@bjoernheyser.de>
 * @author  Martin Studer <ms@studer-raimann.ch>
 * @author  Theodor Truffer <tt@studer-raimann.ch>
 */
abstract class AbstractValueObject implements JsonSerializable {
	const VAR_CLASSNAME = "avo_class_name";


    /**
     * AbstractValueObject constructor.
     */
    protected function __construct() { }


    /**
     * Compares ValueObjects to each other returns true if they are the same
     * 
     * @param AbstractValueObject $other
     * @return bool
     */
    function equals(AbstractValueObject $other) : bool
    {
        return $this->jsonSerialize() == $other->jsonSerialize();
    }

    /**
     * Compares if two nullable ValueObjects are equal and returns true if they are
     * 
     * @param AbstractValueObject $first
     * @param AbstractValueObject $second
     * @return bool
     */
    public static function isNullableEqual(?AbstractValueObject $first, ?AbstractValueObject $second) : bool
    {
        if ($first === null) {
            if ($second === null) {
                return true; //TODO some theorists say null is not equals null but for our purposes it is equal
            } else {
                return false;
            }
        }
        
        if ($second === null) {
            return false;
        }
        
        return $first->equals($second);
    }

	/**
	 * Specify data which should be serialized to JSON
	 *
	 * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
	 * @return mixed data which can be serialized by <b>json_encode</b>,
	 * which is a value of any type other than a resource.
	 * @since 5.4.0
	 */
	public function jsonSerialize() {
	    $json = [];
		$vars = get_object_vars($this);
        foreach ($vars as $key => $var) {
            $json[$key] = $this->sleep($key, $var) ?: $var;
		}
		$json[self::VAR_CLASSNAME] = get_called_class();
		return $json;
	}


    /**
     * @return string
     */
	public function serialize() : string
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * @param stdClass|null $std_data
     *
     * @return AbstractValueObject|null
     */
	public static function jsonDeserialize(?stdClass $std_data) : ?AbstractValueObject
    {
        if ($std_data === null) {
            return null;
        }

        /** @var AbstractValueObject $object */
        $object = new $std_data->{self::VAR_CLASSNAME}();
        $object->setFromStdClass($std_data);

        return $object;
    }


    /**
     * @param string|null $data
     *
     * @return AbstractValueObject|null
     */
    public static function deserialize(?string $data) : ?AbstractValueObject {
		if ($data === null) {
			return null;
		}

		$std_data = json_decode($data);

		return self::jsonDeserialize($std_data);
	}


    /**
     * @param stdClass $data
     */
    private function setFromStdClass(StdClass $data) {
		foreach ($data as $property=>$value) {
		    if ($property != self::VAR_CLASSNAME) {
                $this->$property = $this->wakeUp($property, $value) ?: $value;
            }
		}
	}


    /**
     * @param $field_name
     *
     * @param $field_value
     *
     * @return mixed
     */
    protected function sleep($field_name, $field_value)
    {
        return $field_value instanceof AbstractValueObject ? $field_value->jsonSerialize() : null;
    }


    /**
     * @param $field_name
     * @param $field_value
     *
     * @return mixed
     */
    protected function wakeUp($field_name, $field_value)
    {
        if (($field_value instanceof StdClass) && isset($field_value->{self::VAR_CLASSNAME})) {
            $class_name = $field_value->{self::VAR_CLASSNAME};
            return call_user_func([$class_name, 'jsonDeserialize'], $field_value);
        }
        return null;
    }
}