<?php

namespace Klever\Laravel\ValidationRepository;

use Illuminate\Support\Collection;

class RuleBag
{
    /**
     * The class path that the rules are for.
     *
     * @var string
     */
    public $classPath;

    /**
     * The fields under validation.
     *
     * @var Collection
     */
    public $fields;

    /**
     * Set the class path that the holder is for.
     *
     * @param string $classPath
     */
    public function __construct(string $classPath)
    {
        $this->classPath = $classPath;
        $this->fields = Collection::make();
    }

    /**
     * Return the class path.
     *
     * @return string
     */
    public function getClassPath() : string
    {
        return $this->classPath;
    }

    /**
     * Return the rules as an array.
     *
     * @return array
     */
    public function get() : array
    {
        return $this->fields->map(function ($field) {
            return $field->fieldString();
        })->toArray();
    }

    /**
     * Attach rules to the model.
     *
     * @param array $fieldsAndRules
     * @return self
     */
    public function setRules($fieldsAndRules) : self
    {
        foreach ($fieldsAndRules as $fieldName => $rules) {
            $this->fields->put($fieldName, new Field($fieldName))
                ->get($fieldName)->addRules($rules);
        }

        return $this;
    }

    /**
     * Merge with existing rules on the model.
     *
     * @param array $fieldsAndRules
     * @return self
     */
    public function mergeRules($fieldsAndRules) : self
    {
        foreach ($fieldsAndRules as $fieldName => $rules) {
            $this->fields->get($fieldName)->addRules($rules);
        }

        return $this;
    }

    /**
     * Append rules to a field, creating an index for that field in the array if it does not exist.
     *
     * @param string $fieldName
     * @param array  $rules
     * @return array
     */
    protected function appendRulesToField($fieldName, $rules) : array
    {
        return array_unique(array_merge($this->validationRules[$fieldName] ?? [], $rules));
    }
}
