<?php

namespace Klever\Laravel\ValidationRepository\Tests;

use Klever\Laravel\ValidationRepository\Contracts\ValidationRepository;
use Klever\Laravel\ValidationRepository\Tests\TestCase as TestCase;
use Klever\Laravel\ValidationRepository\ValidationRepositoryTrait;

class ValidationRepositoryTraitTest extends TestCase
{
    /**
     * @var Model
     */
    protected $model;

    public function setUp()
    {
        parent::setUp();

        $this->model = new Model;
    }

    /** @test */
    public function it_accepts_a_repository_class_path_and_returns_the_rules()
    {
        $rules = $this->model->validationRules();

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function it_accepts_multiple_repositories()
    {
        $transformerRules = MultipleRepoModel::transformerRules();
        $validationRules = MultipleRepoModel::validationRules();
        $stateValidationRules = MultipleRepoModel::validationRules('edit');

        $this->assertEquals(['field' => 'trim'], $transformerRules);
        $this->assertEquals(['field' => 'required'], $validationRules);
        $this->assertEquals(['field' => 'date'], $stateValidationRules);
    }

    /** @test */
    public function rules_can_be_retrieved_with_the_get_rules_method()
    {
        $rules = $this->model::getRules('validation');
        $updateRules = $this->model::getRules('validation', 'update');

        $this->assertEquals(['test_field' => 'required'], $rules);
        $this->assertEquals(['test_field' => 'date'], $updateRules);
    }

    /** @test */
    public function a_rule_repository_can_be_attached_using_a_dynamically_named_property()
    {
        $rules = DynamicRepoModel::validationRules();

        $this->assertEquals(['test_field' => 'required'], $rules);
    }
}


class DynamicRepoModel
{
    use ValidationRepositoryTrait;

    protected static $validationRepository = ModelValidationRepository::class;
}

class MultipleRepoModel
{
    use ValidationRepositoryTrait;

    protected static $ruleRepositories = [
        'validation'  => MultipleRepoModelValidationRepository::class,
        'transformer' => MultipleRepoModelTransformerRepository::class,
    ];
}

class MultipleRepoModelValidationRepository implements ValidationRepository
{
    public function default() : array
    {
        return ['field' => 'required'];
    }

    public function edit()
    {
        return ['field' => 'date'];
    }
}

class MultipleRepoModelTransformerRepository implements ValidationRepository
{
    public function default() : array
    {
        return ['field' => 'trim'];
    }
}
