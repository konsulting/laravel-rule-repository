<?php

namespace Klever\Laravel\ValidationRepository;

class Rule
{
    /**
     * The rule name.
     *
     * @var string
     */
    protected $name;

    /**
     * The rule parameters.
     *
     * @var array
     */
    protected $parameters;

    public function __construct($name, $parameters = [])
    {
        $this->name = $name;
        $this->parameters = $parameters;
    }

    /**
     * Get the name of the rule.
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get the rule parameters.
     *
     * @return array
     */
    public function parameters()
    {
        return $this->parameters;
    }

    public function ruleString()
    {
        return $this->name;// . ':' . implode(',', $this->parameters);
    }
}
