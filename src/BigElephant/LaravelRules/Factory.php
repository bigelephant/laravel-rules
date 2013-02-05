<?php namespace BigElephant\LaravelRules;

class Factory {

	/**
	 * Create a new rule and call whatever method was called on the factory.
	 *
	 * @param  string $method
	 * @param  array  $arguments
	 * @return BigElephant\LaravelRules\Rule
	 */
	public function __call($method, $arguments)
	{
		$rule = new Rule;
		
		return call_user_func_array(array($rule, $method), $arguments);
	}
}