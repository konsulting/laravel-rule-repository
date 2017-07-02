<?php

namespace Klever\Laravel\RuleRepository\Tests;

use Klever\Laravel\RuleRepository\Contracts\RuleRepository;
use Klever\Laravel\RuleRepository\Tests\TestCase as TestCase;
use Klever\Laravel\RuleRepository\RuleRepositoryTrait;

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
        $rules = $this->model->getRules('validation');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function it_accepts_multiple_repositories()
    {
        $transformerRules = MultipleRepoModel::getRules('transformer');
        $validationRules = MultipleRepoModel::getRules('validation');
        $stateValidationRules = MultipleRepoModel::getRules('validation','edit');

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
        $rules = DynamicRepoModel::getRules('validation');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }
}


class DynamicRepoModel
{
    use RuleRepositoryTrait;

    protected static $validationRepository = ModelRuleRepository::class;
}

class MultipleRepoModel
{
    use RuleRepositoryTrait;

    protected static $ruleRepositories = [
        'validation'  => MultipleRepoModelRuleRepository::class,
        'transformer' => MultipleRepoModelTransformerRepository::class,
    ];
}

class MultipleRepoModelRuleRepository implements RuleRepository
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

class MultipleRepoModelTransformerRepository implements RuleRepository
{
    public function default() : array
    {
        return ['field' => 'trim'];
    }
}
