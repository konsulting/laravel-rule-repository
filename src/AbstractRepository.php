<?php

namespace Konsulting\Laravel\RuleRepository;

use Konsulting\Laravel\RuleRepository\Contracts\RuleRepository;

abstract class AbstractRepository implements RuleRepository
{
    /**
     * Prepend a rule to all fields. Rules expressed as pipe-delimited strings will be converted to arrays.
     *
     * @param string $rule
     * @param array  $baseRules
     * @return array[]
     */
    protected function prependRule($rule, $baseRules)
    {
        return $this->prependRules([$rule], $baseRules);
    }

    /**
     * Prepend rules to all fields. Rules expressed as pipe-delimited strings will be converted to arrays.
     *
     * @param array $rules
     * @param array $baseRules
     * @return array[]
     */
    protected function prependRules($rules, $baseRules)
    {
        return array_map(function ($ruleLine) use ($rules) {
            return $this->removeDuplicates(
                array_merge($rules, $this->ensureArray($ruleLine))
            );
        }, $baseRules);
    }

    /**
     * Append rules to all fields. Rules expressed as pipe-delimited strings will be converted to arrays.
     *
     * @param array $rules
     * @param array $baseRules
     * @return array[]
     */
    protected function appendRules($rules, $baseRules)
    {
        return array_map(function ($ruleLine) use ($rules) {
            return $this->removeDuplicates(
                array_merge($this->ensureArray($ruleLine), $rules)
            );
        }, $baseRules);
    }

    /**
     * Append a rule to all fields. Rules expressed as pipe-delimited strings will be converted to arrays.
     *
     * @param string $rule
     * @param array  $baseRules
     * @return array[]
     */
    protected function appendRule($rule, $baseRules)
    {
        return $this->appendRules([$rule], $baseRules);
    }

    /**
     * Make sure the rules are expressed in array format.
     *
     * @param array|string|mixed $ruleLine
     * @return array
     */
    private function ensureArray($ruleLine)
    {
        if (empty($ruleLine)) {
            return [];
        } elseif (is_string($ruleLine)) {
            return explode('|', $ruleLine);
        }

        return is_array($ruleLine) ? $ruleLine : [$ruleLine];
    }

    /**
     * Remove duplicate items and reset numerical keys.
     *
     * @param array $array
     * @return array
     */
    private function removeDuplicates($array)
    {
        return array_values(array_unique($array, SORT_REGULAR));
    }
}
