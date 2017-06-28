<?php

namespace Klever\Laravel\ValidationRepository\Tests;

use Klever\Laravel\ValidationRepository\Contracts\HasValidationRepository;
use Klever\Laravel\ValidationRepository\Contracts\ValidationRepository;
use Klever\Laravel\ValidationRepository\ValidationRepositoryTrait;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
}

class Model implements HasValidationRepository
{
    use ValidationRepositoryTrait;

    protected static $ruleRepositories = ['validation' => ModelValidationRepository::class];
}

class ModelValidationRepository implements ValidationRepository
{
    public function default() : array
    {
        return ['test_field' => 'required'];
    }

    public function update()
    {
        return ['test_field' => 'date'];
    }

    public function blankState()
    {
    }

    public function mergedState()
    {
        return ['another_field' => 'required'];
    }

    public function doesNotReturnArray()
    {
        return 'a string is not an array';
    }
}
