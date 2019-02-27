<?php

namespace Konsulting\Laravel\RuleRepository\Tests;

use Konsulting\Laravel\RuleRepository\AbstractRepository;

class AbstractRepositoryTest extends TestCase
{
    /** @test */
    public function it_prepends_a_rule()
    {
        $this->assertEquals([
            'name'  => ['required', 'string'],
            'age'   => ['required', 'int', 'min:18'],
            'empty' => ['required'],
            'email' => ['required', 'string', 'email'],
            'object' => ['required', new \stdClass],
        ], (new Repository)->prepend());
    }

    /** @test */
    public function it_appends_a_rule()
    {
        $this->assertEquals([
            'name'  => ['string', 'required'],
            'age'   => ['int', 'min:18', 'required'],
            'empty' => ['required'],
            'email' => ['string', 'email', 'required'],
            'object' => [new \stdClass, 'required'],
        ], (new Repository)->append());
    }
}

class Repository extends AbstractRepository
{
    public function default(): array
    {
        return [
            'name'   => 'string',
            'age'    => 'int|min:18',
            'empty'  => '',
            'email'  => ['string', 'email'],
            'object' => new \stdClass,
        ];
    }

    public function prepend()
    {
        return $this->prependRule('required', $this->default());
    }

    public function append()
    {
        return $this->appendRule('required', $this->default());
    }
}
