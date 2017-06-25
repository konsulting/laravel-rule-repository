<?php

namespace Klever\Laravel\ValidationRepository\Contracts;

interface HasValidationRepository
{
    /**
     * Return the array of validation rules.
     *
     * @param string $state
     * @return array
     */
    public static function validationRules($state);
}
