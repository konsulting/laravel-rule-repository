<?php

namespace Klever\Laravel\ValidationRepository;

use Exception;


/**
 * Trait ValidationRepositoryTrait
 *
 * @method static array validationRules
 * @method static array transformerRules
 */
trait ValidationRepositoryTrait
{
    /**
     * The repository holder instance.
     *
     * @var RepositoryManager
     */
    protected static $repositoryInstances;

    /**
     * Return the array of validation rules.
     *
     * @param string $repositoryName
     * @param string $state
     * @return array
     */
    public static function getRules($repositoryName, $state = null)
    {
        return static::getInstance($repositoryName)->getRules($state);
    }

    /**
     * @param string $method
     * @param array  $args
     * @return array
     */
    public static function __callStatic(string $method, array $args = [])
    {
        $repositoryName = static::extractRepositoryNameFromMethod($method);
        if ($repositoryName) {
            return static::getRules($repositoryName, ...$args);
        }

        if (get_parent_class(static::class)) {
            return parent::__callStatic($method, $args);
        }

        return null;
    }

    /**
     * @param string $method
     * @param array  $args
     * @return array
     */
    public function __call(string $method, array $args = [])
    {
        $repositoryName = static::extractRepositoryNameFromMethod($method);
        if ($repositoryName) {
            return static::getRules($repositoryName, ...$args);
        }

        if (get_parent_class($this)) {
            return parent::__call($method, $args);
        }

        return null;
    }

    /**
     * Get the validation repository instance for the class.
     *
     * @param $name
     * @return RepositoryManager
     * @throws Exception
     */
    protected static function getInstance($name)
    {
        if ( ! static::$ruleRepositories) {
            throw new Exception('No validation repository classes set. Please set the ruleRepositories property.');
        }

        return static::$repositoryInstances[$name]
            ?? (static::$repositoryInstances[$name] = new RepositoryManager(new static::$ruleRepositories[$name]));
    }

    /**
     * Check if the method name ends in 'Rules'. If it does, return the extracted preceding repository name; if not
     * return null.
     *
     * @param string $method
     * @return string|null
     */
    private static function extractRepositoryNameFromMethod($method)
    {
        return substr($method, -5) == 'Rules'
            ? str_replace('Rules', '', $method)
            : null;
    }
}
