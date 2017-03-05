<?php

namespace Konsulting\Laravel\ValidationRepo;

use Model;
use ValidationRepoTestCase as TestCase;

class ValidationRepoTest extends TestCase
{
    /** @test */
    function it_loads_a_rule_holder()
    {
        $holder = (new ValidationRepo)->for(Model::class);

        $this->assertInstanceOf(ValidationRuleHolder::class, $holder);
    }

    /** @test */
    function it_loads_a_singleton_rule_holder()
    {
        $repository = new ValidationRepo;
        $holder = $repository->for(Model::class);
        $holder2 = $repository->for(Model::class);

        $this->assertSame($holder, $holder2);
    }
}
