<?php

namespace Klever\Laravel\ValidationRepository;

use Exception;
use Illuminate\Support\Collection;


/**
 * Trait ValidationRepositoryTrait
 *
 * @method static array validationRules(string $state = '')
 * @method static array transformerRules(string $state = '')
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
     * @var Collection
     */
    protected static $masterRepositoryList;

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
        $repositoryName = static::extractFromString($method, 'Rules');
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
        $repositoryName = static::extractFromString($method, 'Rules');
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
        static::$masterRepositoryList = collect();

        if (isset(static::$ruleRepositories)) {
            static::$masterRepositoryList = collect(static::$ruleRepositories);
        }

        static::extractRepositoriesFromProperties();

//        if ( ! static::$ruleRepositories) {
//            throw new Exception('No validation repository classes set. Please set the ruleRepositories property.');
//        }

        return static::$repositoryInstances[$name]
            ?? (static::$repositoryInstances[$name] = new RepositoryManager(new static::$masterRepositoryList[$name]));
    }

    /**
     * Check if $string ends in $search. If it does, extract and return the string minus the search string; if not
     * return null.
     *
     * @param string $string
     * @param string $search
     * @return string
     */
    private static function extractFromString($string, $search)
    {
        return substr($string, 0 - strlen($search)) == $search
            ? str_replace($search, '', $string)
            : null;
    }

    private static function extractRepositoriesFromProperties()
    {
        foreach (get_class_vars(static::class) as $key => $value) {
            $repositoryName = static::extractFromString($key, 'Repository');
            if ($repositoryName) {
                static::$masterRepositoryList->put($repositoryName, $value);
            }
        }
    }
}
