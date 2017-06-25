# Laravel Validation Repository
A package to centralise the storage and organisation of validation rules, whilst avoiding storing them on the model or controller.

## Installation
Install via Composer:
```
composer install klever/laravel-validation-repository
```

## Usage
Each model under validation should have its own validation repository attached to it, containing default validation rules and, optionally, validation rules for different states.
You may, for example, require different validation rules when updating the model as opposed to creating it.

### Creating the repository
The validation repository must implement `Contracts\ValidationRepository`, and as such must contain a `default()` method which returns an array of default validation rules.
It may also contain any number of 'state' methods which contain differing validation rules.
**These state-specific rules will be merged with the default rules when they are retrieved.**

```php
use Klever\Laravel\ValidationRepository\Contracts\ValidationRepository;

class UserValidationRepository implements ValidationRepository
{
    public function default() : array
    {
        'name'          => 'required';
        'email'         => 'required|email';
        'date_of_birth' => 'required|date';
    }
    
    public function update() : array
    {
        // Rules here may override or add to the default rules.
    }
}
```

### Attaching the repository to the model
The model to be validated should use the `ValidationRepositoryTrait`. 
It is recommended (but not required) that the model implements the interface `Contracts\HasValidationRepository`.

The static property `validationRepository` should be set to the class path of the validation repository.
```php
use Klever\Laravel\ValidationRepository\Contracts\HasValidationRepository;
use Klever\Laravel\ValidationRepository\ValidationRepositoryTrait;

class User extends Model implements HasValidationRepository
{
    use ValidationRepositoryTrait;

    protected static $validationRepository = UserValidationRepository::class;
}
```

### Retrieving validation rules
The model's validation rules can be retrieved using the static `validationRules()` method, which is added to the model by the trait `ValidationRepositoryTrait`.

To return the default rules:
```php
User::validationRules();

// or

User::validationRules('default');
```

To get state-specific rules:
```php
User::validationRules('update');

User::validationRules($stateName);
```
States may be named in either camel-case or snake-case.
