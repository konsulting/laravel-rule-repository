<?php

namespace Klever\Laravel\ValidationRepository;

class Field
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $rules;

    public function __construct($name, $rules = [])
    {
        $this->name = $name;
        $this->rules = $rules;
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
     * Split the rule string into an array of rules.
     *
     * @param string $rules
     * @return array
     */
    protected function explodeRules($rules) : array
    {
        return explode('|', $rules);
    }

    public function addRules($rules)
    {
        $rules = is_string($rules) ? $this->explodeRules($rules) : $rules;

        foreach ($rules as $rule) {
            $this->addRule($rule);
        }
    }

    public function addRule($rule)
    {
        $this->rules[] = new Rule($rule);
    }

    public function fieldString()
    {
        $rules = [];
        foreach ($this->rules as $rule) {
            $rules[] = $rule->ruleString();
        }

        return implode('|', $rules);
    }
}
