<?php

namespace Klever\Laravel\ValidationRepository;

use Klever\Laravel\ValidationRepository\ValidationRepositoryTestCase as TestCase;

class RuleTest extends TestCase
{
    /** @test */
    public function it_holds_a_name_and_parameters()
    {
        $rule = new Rule('my_rule', ['param1', 'param2']);

        $this->assertEquals('my_rule', $rule->name());
        $this->assertEquals(['param1', 'param2'], $rule->parameters());
    }
}
