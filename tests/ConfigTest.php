<?php

namespace Klever\Laravel\RuleRepository\Tests;

use Klever\Laravel\RuleRepository\RepositoryMagicMethods;
use Klever\Laravel\RuleRepository\RuleRepositoryTrait;

class ConfigTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        $app['config']->set('rule_repository', [
            'property_suffix' => 'ListOfConstraints',
            'method_suffix'   => 'GetConstraints',
        ]);
    }

    /** @test */
    public function the_property_suffix_can_be_defined_in_the_config()
    {
        $rules = ModelCustomSuffixes::getRules('custom');

        $this->assertEquals(['test_field' => 'required'], $rules);
    }

    /** @test */
    public function the_method_suffix_can_be_defined_in_the_config()
    {
        $rules = ModelCustomSuffixes::customGetConstraints();

        $this->assertEquals(['test_field' => 'required'], $rules);
    }
}

class ModelCustomSuffixes
{
    use RuleRepositoryTrait, RepositoryMagicMethods;

    protected $customListOfConstraints = ModelRuleRepository::class;
}
