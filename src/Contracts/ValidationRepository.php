<?php

namespace Klever\Laravel\RuleRepository\Contracts;

interface ValidationRepository
{
    /**
     * Get the default validation rule array.
     *
     * @return array
     */
    public function default() : array;
}
