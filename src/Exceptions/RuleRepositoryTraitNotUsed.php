<?php

namespace Konsulting\Laravel\RuleRepository\Exceptions;

use Exception;
use Throwable;

class RuleRepositoryTraitNotUsed extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = $message ?: 'The Rule Repository trait must be used by the target class.';

        parent::__construct($message, $code, $previous);
    }
}
