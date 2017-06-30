<?php

namespace Klever\Laravel\RuleRepository\Tests;

use Klever\Laravel\RuleRepository\Exceptions\RuleRepositoryTraitNotUsed;
use Klever\Laravel\RuleRepository\RepositoryMagicMethods;
use Klever\Laravel\RuleRepository\RuleRepositoryTrait;
use Klever\Laravel\RuleRepository\Tests\Model as BaseModel;

class RepositoryMagicMethodsTest extends TestCase
{
    /** @test */
    public function it_throws_an_exception_on_call_if_the_rule_repository_trait_is_not_also_on_the_class()
    {
        $object = new OnlyHasMagicMethodsTrait;

        $this->expectException(RuleRepositoryTraitNotUsed::class);
        $object->__call('test', []);
    }

    /** @test */
    public function it_throws_an_exception_on_call_static_if_the_rule_repository_trait_is_not_also_on_the_class()
    {
        $this->expectException(RuleRepositoryTraitNotUsed::class);
        OnlyHasMagicMethodsTrait::__callStatic('test', []);
    }

    /** @test */
    public function rules_can_be_retrieved_with_a_correspondingly_named_magic_method()
    {
        $staticRules = MagicMethodModel::validationRules();
        $instanceRules = (new MagicMethodModel)->validationRules();

        $this->assertEquals(['test_field' => 'required'], $staticRules);
        $this->assertEquals(['test_field' => 'required'], $instanceRules);
    }

    /** @test */
    public function it_does_not_interfere_with_parent_class_magic_method_calls()
    {
        $this->assertEquals(['test_field' => 'required'], EloquentModel::validationRules());

        $this->expectException(\PDOException::class);
        dd(EloquentModel::where('1=1')->get());
    }
}

class OnlyHasMagicMethodsTrait
{
    use RepositoryMagicMethods;
}

class MagicMethodModel extends BaseModel
{
    use RuleRepositoryTrait, RepositoryMagicMethods;
}

class EloquentModel extends \Illuminate\Database\Eloquent\Model
{
    use RuleRepositoryTrait, RepositoryMagicMethods;

    protected $validationRepository = ModelValidationRepository::class;
}
