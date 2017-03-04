<?php

namespace Konsulting\Laravel\ValidationRepo;

class ValidationRuleHolder
{

    /**
     * The class path that the rules are for.
     *
     * @var string
     */
    public $classPath;

    /**
     * The validation rules.
     *
     * @var array
     */
    public $validationRules = [];

    /**
     * Set the class path that the holder is for.
     *
     * @param string $classPath
     */
    public function __construct(string $classPath)
    {
        $this->classPath = $classPath;
    }

    /**
     * Return the class path.
     *
     * @return string
     */
    public function getClassPath(): string
    {
        return $this->classPath;
    }

    /**
     * Return the rules as an array.
     *
     * @return array
     */
    public function get(): array
    {
        foreach ($this->validationRules as $fieldName => $rules) {
            $ruleArray[$fieldName] = implode('|', $rules);
        }

        return $ruleArray ?? [];
    }

    /**
     * Attach rules to the model.
     *
     * @param array $fieldsAndRules
     * @return self
     */
    public function setRules($fieldsAndRules): self
    {
        foreach ($fieldsAndRules as $fieldName => $rules) {
            $this->validationRules[$fieldName] = $this->explodeRules($rules);
        }

        return $this;
    }

    /**
     * Merge with existing rules on the model.
     *
     * @param array $fieldsAndRules
     * @return self
     */
    public function mergeRules($fieldsAndRules): self
    {
        foreach ($fieldsAndRules as $fieldName => $rules) {
            $this->validationRules[$fieldName] = $this->appendRulesToField($fieldName, $this->explodeRules($rules));
        }

        return $this;
    }

    /**
     * Split the rule string into an array of rules.
     *
     * @param string $rules
     * @return array
     */
    protected function explodeRules($rules): array
    {
        return explode('|', $rules);
    }

    /**
     * Append rules to a field, creating an index for that field in the array if it doesn't exist.
     *
     * @param string $fieldName
     * @param array  $rules
     * @return array
     */
    protected function appendRulesToField($fieldName, $rules): array
    {
        return array_unique(array_merge($this->validationRules[$fieldName] ?? [], $rules));
    }
}
