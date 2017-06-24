<?php

namespace Klever\Laravel\ValidationRepository;

use Klever\Laravel\ValidationRepository\ValidationRepositoryTestCase as TestCase;

class FieldTest extends TestCase
{
    /** @test */
    public function it_holds_a_name_and_parameters()
    {
        $rules = [
            new Rule('rule1'),
            new Rule('rule2', ['param'])
        ];

        $field = new Field('my_field', $rules);

        $this->assertEquals('my_field', $field->name());
        $this->assertEquals($rules, $field->rules());
    }
}
