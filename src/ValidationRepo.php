<?php

namespace Konsulting\Laravel\ValidationRepo;

class ValidationRepo
{
    /**
     * The validation rules and the class paths to apply them to.
     *
     * @var array
     */
    public $ruleHolders = [];

    /**
     * Return the rule holder for the specified class.
     *
     * @param string|object $class
     * @return ValidationRuleHolder
     */
    public function for ($class): ValidationRuleHolder
    {
        $model = $this->getClassPath($class);

        return $this->singleton($model);
    }

    /**
     * Create a new instance and load in rules from config if needed, then return the instance.
     *
     * @param $model
     * @return mixed
     */
    protected function singleton($model)
    {
        $c = config('validation_repo.' . $model) ?? [];
        if ( ! isset($this->ruleHolders[$model])) {
            $this->ruleHolders[$model] = (new ValidationRuleHolder($model))
                ->setRules($c);
        }

        return $this->ruleHolders[$model];
    }

    /**
     * Return the class path string.
     *
     * @param $class
     * @return string
     */
    protected function getClassPath($class): string
    {
        return is_string($class) ? $class : get_class($class);
    }
}
