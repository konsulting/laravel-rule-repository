<?php

namespace Klever\Laravel\RuleRepository;

use Klever\Laravel\RuleRepository\Contracts\RuleRepository;
use Klever\Laravel\RuleRepository\Exceptions\NonExistentStateException;

class RepositoryManager
{
    /**
     * The repository instance.
     *
     * @var RuleRepository
     */
    protected $repository;

    /**
     * Set the repository instance.
     *
     * @param RuleRepository $repository
     */
    public function __construct(RuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return the rules for the given state. Get the default state if not specified.
     *
     * @param string $state
     * @return array
     * @throws NonExistentStateException
     */
    public function getRules($state = null)
    {
        $method = camel_case($state ?? 'default');

        if ( ! method_exists($this->repository, $method)) {
            throw new NonExistentStateException($method);
        }

        return array_merge(
            $this->repository->default(),
            is_array($this->repository->$method()) ? $this->repository->$method() : []
        );
    }
}
