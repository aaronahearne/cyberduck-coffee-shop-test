<?php

namespace App\Exceptions;

use Exception;

class MissingAttributeForCalculationException extends Exception
{
    public function __construct(string $attributeName, $code = 0, ?Exception $previous = null)
    {
        parent::__construct('Missing attribute required for calculation: '.$attributeName, $code, $previous);
    }
}
