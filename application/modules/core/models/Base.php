<?php

namespace Application\Modules\Core\Models;

/**
 * Application
 *
 *
 * @package       Base
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Holds common functions used by all the model classes for code reuse.
 */
abstract class Base
{

    /**
     * Takes an array of properites and sets them in class by calling getter methods
     *
     * @param array $properties  An array of class properties
     * @return N/A
     * @throws OrionException
     */
    public function setProperties(array $properties)
    {
        $_classMethods = get_class_methods($this);
        foreach ($properties as $property => $value)
        {
            $method = 'set' . ucfirst($property);
            if (in_array($method, $_classMethods))
            {
                $this->$method($value);
            } else
            {
                throw new OrionException("Property ".$property." doesn't belong to ".get_called_class()." class.");
            }
        }
    }
    
}