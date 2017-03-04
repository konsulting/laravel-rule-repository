<?php
namespace Konsulting\Laravel\ValidationRepo;

use Illuminate\Support\Facades\Facade;

class ValidationRepoFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ValidationRepo::class;
    }
}
