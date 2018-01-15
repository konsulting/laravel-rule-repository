<?php

namespace Konsulting\Laravel\RuleRepository\Exceptions;

use Exception;
use Throwable;

class NonExistentStateException extends Exception
{
    /**
     * Construct the exception.
     *
     * @param string         $state
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($state = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct('The state "' . $state . '" does not exist in the target repository.',
            $code,
            $previous
        );
    }
}
