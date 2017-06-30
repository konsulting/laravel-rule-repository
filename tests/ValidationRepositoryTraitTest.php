<?php

namespace Klever\Laravel\RuleRepository\Tests;

use Klever\Laravel\RuleRepository\Contracts\ValidationRepository;
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

    /** @test */
    public function model()
    {
        $this->assertEquals(['test_field' => 'required'], EloquentModel::getRules('validation'));

        $this->expectException(\PDOException::class);
        dd(EloquentModel::where('1=1')->get());
    }
}


class DynamicRepoModel
{
    use RuleRepositoryTrait;

    protected static $validationRepository = ModelValidationRepository::class;
}

class MultipleRepoModel
{
    use RuleRepositoryTrait;

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

class EloquentModel extends \Illuminate\Database\Eloquent\Model
{
    use RuleRepositoryTrait;

    protected $validationRepository = ModelValidationRepository::class;
}
