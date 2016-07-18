<?php

namespace Application\Modules\Core\Models;

use Exception;

/**
 * OrionException
 *
 *
 * @package       Models
 * @author        Jay Bhatt <jay_bhatt@live.com>
 * @description   Wrapper for the Exception class, adds line number and file name to each execption message.
 */
class OrionException extends Exception
{
    /**
     * Apeends the file name and line number to every exception message.
     *
     * @param string $message  Name of class being called
     * @param boolean $method  Name of the method in which caused the exception.
     */
    public function __construct($message = null, $method = FALSE, $args = FALSE)
    {
        $this->message = $message." (File: ".$this->getFile().", Line number : ".$this->getLine().")";
    }
}