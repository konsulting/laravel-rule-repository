<?php
namespace Klever\Laravel\ValidationRepository;

use Illuminate\Support\Facades\Facade;

class ValidationRepositoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidationRepository::class;
    }
}
