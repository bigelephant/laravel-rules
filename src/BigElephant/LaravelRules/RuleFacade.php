<?php namespace BigElephant\LaravelRules;

use Illuminate\Support\Facades\Facade;

class RuleFacade extends Facade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor() { return 'rule'; }
}