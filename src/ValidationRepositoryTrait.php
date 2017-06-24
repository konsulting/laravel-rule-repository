<?php

namespace Klever\Laravel\ValidationRepository;

use Exception;

trait ValidationRepositoryTrait
{
    protected $validationRepository;
    protected $repositoryInstance;

    /**
     * Return the array of validation rules.
     *
     * @param string $state
     * @return array
     */
    public function validate($state = null)
    {
        return $this->repositoryInstance->$state();
    }

    /**
     * Get the validation repository instance for the class.
     *
     * @return ValidationRepository
     * @throws Exception
     */
    protected function getInstance()
    {
        if ( ! $this->validationRepository) {
            throw new Exception('No validation repository class set.');
        }

        return $this->repositoryInstance
            ?: $this->repositoryInstance = new ValidationRepository();
    }
}
