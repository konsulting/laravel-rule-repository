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
    protected $repositoryInstance;

    /**
     * Return the array of validation rules.
     *
     * @param string $state
     * @return array
     */
    public function validationRules($state = null)
    {
        return $this->getInstance()->getRules($state);
    }

    /**
     * Get the validation repository instance for the class.
     *
     * @return RepositoryHolder
     * @throws Exception
     */
    protected function getInstance()
    {
        if ( ! $this->validationRepository) {
            throw new Exception('No validation repository class set. Please set the validationRepository property.');
        }

        return $this->repositoryInstance
            ?: $this->repositoryInstance = new RepositoryHolder(new $this->validationRepository);
    }
}
