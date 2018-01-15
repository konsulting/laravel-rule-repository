<?php

namespace Konsulting\Laravel\RuleRepository;

use Exception;
use Illuminate\Support\Collection;

trait RuleRepositoryTrait
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
     * Get the instance of the specified rule repository. If the repository is not already instantiated, instantiate
     * and store it in the repository instances array.
     *
     * @param string $name
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
            $repositoryName = static::extractFromString($key,
                config('rule_repository.property_suffix', 'Repository'));

            if ($repositoryName) {
                static::$masterRepositoryList->put($repositoryName, $value);
            }
        }
    }
}
