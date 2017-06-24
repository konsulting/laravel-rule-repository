<?php

namespace Klever\Laravel\ValidationRepository;

use Klever\Laravel\ValidationRepository\ValidationRepositoryTestCase as TestCase;

class ValidationRepositoryTest extends TestCase
{
    /** @test */
    function it_loads_a_rule_holder()
    {
        $holder = (new ValidationRepository)->for(Model::class);

        $this->assertInstanceOf(RuleBag::class, $holder);
    }

    /** @test */
    function it_loads_a_singleton_rule_holder()
    {
        $repository = new ValidationRepository;
        $holder = $repository->for(Model::class);
        $holder2 = $repository->for(Model::class);

        $this->assertSame($holder, $holder2);
    }
}
