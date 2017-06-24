<?php

namespace Klever\Laravel\ValidationRepository;

class ValidationRepository
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
     * @return RuleBag
     */
    public function for ($class) : RuleBag
    {
        $model = $this->getClassPath($class);

        return $this->singleton($model);
    }

    /**
     * Create a new rule holder instance if needed, then return the instance.
     *
     * @param $model
     * @return RuleBag
     */
    protected function singleton($model) : RuleBag
    {
        if ( ! isset($this->ruleHolders[$model])) {
            $this->ruleHolders[$model] = $this->newRuleHolder($model);
        }

        return $this->ruleHolders[$model];
    }

    /**
     * Return the class path string.
     *
     * @param $class
     * @return string
     */
    protected function getClassPath($class) : string
    {
        return is_string($class) ? $class : get_class($class);
    }

    /**
     * Instantiate a new rule holder and set the rules from config if required.
     *
     * @param string $model
     * @return RuleBag
     */
    protected function newRuleHolder($model) : RuleBag
    {
        return (new RuleBag($model))
            ->setRules($this->getInitialRules($model));
    }

    /**
     * Fetch the rules for a given model from the config.
     *
     * @param $model
     * @return array
     */
    protected function getInitialRules($model) : array
    {
        return config('validation_repo.' . $model) ?? [];
    }
}
