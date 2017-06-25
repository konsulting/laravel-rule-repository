<?php

namespace Klever\Laravel\ValidationRepository\Tests;

use Klever\Laravel\ValidationRepository\Tests\TestCase as TestCase;

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
}
