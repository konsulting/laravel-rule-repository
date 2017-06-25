<?php

namespace Klever\Laravel\ValidationRepository;

use Exception;

trait ValidationRepositoryTrait
{
    /**
     * The repository holder instance.
     *
     * @var RepositoryHolder
     */
    protected static $repositoryInstance;

    /**
     * Return the array of validation rules.
     *
     * @param string $state
     * @return array
     */
    public static function validationRules($state = null)
    {
        return static::getInstance()->getRules($state);
    }

    /**
     * Get the validation repository instance for the class.
     *
     * @return RepositoryHolder
     * @throws Exception
     */
    protected static function getInstance()
    {
        if ( ! static::$validationRepository) {
            throw new Exception('No validation repository class set. Please set the validationRepository property.');
        }

        return static::$repositoryInstance
            ?: static::$repositoryInstance = new RepositoryHolder(new static::$validationRepository);
    }
}
