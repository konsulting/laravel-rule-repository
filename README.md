# Laravel Rule Repository
[![Build Status](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/badges/build.png?b=master)](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/klever/laravel-rule-repository/?branch=master)

A package to allow rules (for example validation rules) to be attached to a model, whilst avoiding storing them on the model itself or in a controller.

## Installation
Install via Composer:
```
composer require klever/laravel-rule-repository
```

## Usage
Each model under validation should have its own validation repository attached to it, containing default validation rules and, optionally, validation rules for different states.
You may, for example, require different validation rules when updating the model as opposed to creating it.

### Creating the repository
The validation repository must implement `Contracts\RuleRepository`, and as such must contain a `default()` method which returns an array of default rules.
It may also contain any number of 'state' methods which contain differing rules.
**These state-specific rules will be merged with the default rules when they are retrieved.**

State methods names should use camel case.

```php
use Klever\Laravel\RuleRepository\Contracts\RuleRepository;

class UserRuleRepository implements RuleRepository
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
The model to attach the rules to should use the `RuleRepositoryTrait` trait. 
It is recommended (but not required) that the model implements the interface `Contracts\HasRuleRepositories`.

The static property `$ruleRepositories` should be initialised to an associative array of repository class paths, with the repository name as the key.
```php
use Klever\Laravel\RuleRepository\Contracts\HasRuleRepository;
use Klever\Laravel\RuleRepository\RuleRepositoryTrait;

class User extends Model implements HasRuleRepository
{
    use RuleRepositoryTrait;

    protected static $ruleRepositories = [
        'validation' => UserValidationRepository::class;
    ];
}
```

### Retrieving validation rules
The model's validation rules can be retrieved using the static method `getRules($name, $state = 'default')`.

To return the default rules for the validation repository:
```php
User::getRules('validation');

// or

User::getRules('validation', 'default');
```

To get state-specific rules:
```php
User::getRules('validation', 'update');

User::getRules('validation', $state);
```
States may be named in either camel-case or snake-case.

#### Using magic methods
The `RepositoryMagicMethods` trait may also be added to the model to allow rules to be retrieved with a more concise syntax.
Rules may be retrieved using:

```php
Model::{$repositoryName . 'Rules'}($state = 'default');
```

For example:

```php
User::validationRules();

User::validationRules('update');
```
