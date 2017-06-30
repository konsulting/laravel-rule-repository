<?php

namespace Klever\Laravel\RuleRepository\Tests;

use Klever\Laravel\RuleRepository\Exceptions\NonExistentStateException;
use Klever\Laravel\RuleRepository\RepositoryManager;
use Klever\Laravel\RuleRepository\Tests\TestCase as TestCase;

class RepositoryManagerTest extends TestCase
{
    /**
     * @var RepositoryManager
     */
    protected $holder;

    public function setUp()
    {
        parent::setUp();

        $this->holder = new RepositoryManager(new ModelValidationRepository);
    }

    /** @test */
    public function it_accepts_a_validation_repository_and_returns_the_default_rules_from_it()
    {
        $rules = $this->holder->getRules();

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function it_returns_the_rules_for_a_given_state()
    {
        $rules = $this->holder->getRules('update');

        $this->assertEquals(['test_field' => 'date'], $rules);
    }

    /** @test */
    public function all_states_inherit_the_default_state()
    {
        $rules = $this->holder->getRules('blankState');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function a_states_rules_are_merged_with_the_default_state_rules()
    {
        $rules = $this->holder->getRules('merged_state');

        $expected = [
            'test_field'    => 'required',
            'another_field' => 'required',
        ];
        $this->assertEquals($expected, $rules);
    }

    /** @test */
    public function a_state_may_be_called_as_snake_case()
    {
        $rules = $this->holder->getRules('blank_state');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function it_throws_an_exception_if_a_state_does_not_exist()
    {
        $this->expectException(NonExistentStateException::class);
        $this->holder->getRules('non_existent_state');
    }

    /** @test */
    public function it_returns_the_default_state_rules_if_the_target_state_method_exists_but_does_not_return_an_array()
    {
        $rules = $this->holder->getRules('does_not_return_array');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }
}
