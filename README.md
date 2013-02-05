Laravel Rules
=============

Alternative way to define rules in laravel.

This is just for a more PHP like syntax on rules with laravel. I personally find it easier to read at a glance. Also designed to be used in your own validators.

### Normal rules in Laravel
```php
	$rules = [
		'username' 	=> 'required|alphaDash|between:3,100',
		'email'		=> 'required|email',
		'password' 	=> 'required|confirmed|min:5',

		'terms' 	=> 'accepted',
	];
```

### Under this new syntax
```php
	$rules = [
		'username' 	=> Rule::required()->alphaDash()->between(3, 100),
		'email'		=> Rule::required()->email(),
		'password'	=> Rule::required()->confirmed()->min(5),

		'terms'		=> Rule::accepted(),
	];
```
### Installation

Add the following to the "require" section of your `composer.json` file:

```json
	"bigelephant/laravel-rules": "dev-master"
```

Edit the `app/config/app.php` file and...

* Add the following to your `providers` array:

```php
	'BigElephant\LaravelRules\RuleServiceProvider',
```

* Add the following to your `aliases` array:
```php
	'Rule' => 'BigElephant\LaravelRules\RuleFacade',
```