<?php

namespace Konsulting\Laravel\RuleRepository\Contracts;

interface HasRuleRepositories
{
    /**
     * Return the array of rules for a given repository.
     *
     * @param string $repositoryName
     * @param string $state
     * @return array
     */
    public static function getRules($repositoryName, $state = null);
}
