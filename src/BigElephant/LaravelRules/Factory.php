<?php namespace BigElephant\LaravelRules;

class Factory {

	public function __call($method, $arguments)
	{
		$rule = new Rule;
		
		return call_user_func_array(array($rule, $method), $arguments);
	}
}