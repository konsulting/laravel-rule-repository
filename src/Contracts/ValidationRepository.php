<?php

namespace Klever\Laravel\ValidationRepository\Contracts;

interface ValidationRepository
{
    /**
     * Get the default validation rule array.
     *
     * @return array
     */
    public function default() : array;
}
