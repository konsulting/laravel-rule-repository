<?php

namespace Konsulting\Laravel\RuleRepository\Contracts;

interface RuleRepository
{
    /**
     * Get the default validation rule array.
     *
     * @return array
     */
    public function default() : array;
}
