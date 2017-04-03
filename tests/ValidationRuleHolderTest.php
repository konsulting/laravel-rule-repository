<?php

namespace Klever\Laravel\ValidationRepository;

use Model;
use ValidationRepositoryTestCase as TestCase;

class ValidationRuleHolderTest extends TestCase
{
    /** @test */
    function it_returns_the_class_name()
    {
        $className = (new ValidationRepository)->for(Model::class)->getClassPath();

        $this->assertEquals(Model::class, $className);
    }

    /** @test */
    function an_array_of_rules_can_be_set()
    {
        $rules = ['field' => 'rule1|rule2', 'field2' => 'rule3|rule4:param'];
        $returnedRules = (new ValidationRepository)->for(Model::class)->setRules($rules)->get();

        $this->assertEquals($rules, $returnedRules);
    }

    /** @test */
    function rules_can_be_overridden_by_a_new_rule_array()
    {
        $expected = ['field' => 'overridden', 'field2' => 'rule3|rule4:param'];
        $returnedRules = (new ValidationRepository)->for(Model::class)
            ->setRules(['field' => 'rule1|rule2', 'field2' => 'rule3|rule4:param'])
            ->setRules(['field' => 'overridden'])
            ->get();

        $this->assertEquals($expected, $returnedRules);
    }

    /** @test */
    function a_new_rule_array_can_be_merged_in()
    {
        $expected = ['field' => 'rule1|rule2|merged', 'field2' => 'rule3|rule4:param'];
        $returnedRules = (new ValidationRepository)->for(Model::class)
            ->setRules(['field' => 'rule1|rule2', 'field2' => 'rule3|rule4:param'])
            ->mergeRules(['field' => 'merged'])
            ->get();

        $this->assertEquals($expected, $returnedRules);
    }
}
