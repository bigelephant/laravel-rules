<?php

use BigElephant\LaravelRules\Rule;

class RuleTest extends PHPUnit_Framework_TestCase {

	public function testBasicDefinedRules()
	{
		$this->assertRuleSame($this->rule()->string(), 		'');
		$this->assertRuleSame($this->rule()->required(),	'required');
		$this->assertRuleSame($this->rule()->confirmed(),	'confirmed');
		$this->assertRuleSame($this->rule()->accepted(),	'accepted');
		$this->assertRuleSame($this->rule()->numeric(),		'numeric');
		$this->assertRuleSame($this->rule()->integer(),		'integer');
		$this->assertRuleSame($this->rule()->ip(), 			'ip');
		$this->assertRuleSame($this->rule()->email(), 		'email');
		$this->assertRuleSame($this->rule()->url(), 		'url');
		$this->assertRuleSame($this->rule()->activeUrl(), 	'activeUrl');
		$this->assertRuleSame($this->rule()->image(), 		'image');
		$this->assertRuleSame($this->rule()->alpha(), 		'alpha');
		$this->assertRuleSame($this->rule()->alphaNum(), 	'alphaNum');
		$this->assertRuleSame($this->rule()->alphaDash(), 	'alphaDash');
		$this->assertRuleSame($this->rule()->date(), 		'date');
	}

	public function testArrayDefinedRules()
	{
		$this->assertRuleSame(
			$this->rule()->requiredWith('one', 'two')->requiredWith(array('three', 'four')),
			'requiredWith:one,two|requiredWith:three,four'
		);

		$this->assertRuleSame(
			$this->rule()->in('one', 'two')->in(array('three', 'four')),
			'in:one,two|in:three,four'
		);

		$this->assertRuleSame(
			$this->rule()->notIn('one', 'two')->notIn(array('three', 'four')),
			'notIn:one,two|notIn:three,four'
		);

		$this->assertRuleSame(
			$this->rule()->mimes('one', 'two')->mimes(array('three', 'four')),
			'mimes:one,two|mimes:three,four'
		);
	}

	public function testSpecificDefinedRules()
	{
		$this->assertRuleSame($this->rule()->same('blah'), 			'same:blah');
		$this->assertRuleSame($this->rule()->different('blah'), 	'different:blah');
		$this->assertRuleSame($this->rule()->digits(2), 			'digits:2');
		$this->assertRuleSame($this->rule()->digitsBetween(4, 7), 	'digitsBetween:4,7');
		$this->assertRuleSame($this->rule()->size(69), 				'size:69');
		$this->assertRuleSame($this->rule()->between(6, 9), 		'between:6,9');
		$this->assertRuleSame($this->rule()->min(6436), 			'min:6436');
		$this->assertRuleSame($this->rule()->max(42), 				'max:42');
		$this->assertRuleSame($this->rule()->exists('blah', 'col'), 'exists:blah,col');
		$this->assertRuleSame($this->rule()->regex('\s'), 			'regex:\s');
		$this->assertRuleSame($this->rule()->dateFormat('Y'), 		'dateFormat:Y');
		$this->assertRuleSame($this->rule()->before('blah'), 		'before:blah');
		$this->assertRuleSame($this->rule()->after('blah'), 		'after:blah');
		$this->assertRuleSame($this->rule()->unique('users', 'email', 20, 'some_id'), 'unique:users,email,20,some_id');
	}

	public function testChainedRulesAndCount()
	{
		$rule = $this->rule()->required()->url()->notIn('one', 'two')->unique('users', 'url', 20, 'some_id');
		$this->assertRuleSame($rule, 'required|url|notIn:one,two|unique:users,url,20,some_id');
		$this->assertSame(count($rule), 4);
	}

	public function testCustomRules()
	{
		$rule = new Rule;
		$rule->required()->email()->custom();
		$this->assertRuleSame($rule, 'required|email|custom');

		$rule = new Rule;
		$rule->required()->email()->customWithExtra('param1', 'param2');
		$this->assertRuleSame($rule, 'required|email|customWithExtra:param1,param2');
	}

	protected function rule()
	{
		return new RuleStub;
	}

	protected function assertRuleSame($rule, $string)
	{
		$this->assertTrue($rule instanceof Rule);
		$this->assertSame((string) $rule, $string);
	}
}

class RuleStub extends Rule {

	// When we only want to test defined rules
	public function __call($method, $arguments)
	{
		$actualMethod = 'rule'.camel_case($method);
		if (method_exists($this, $actualMethod))
		{
			return call_user_func_array(array($this, $actualMethod), $arguments);
		}


		throw new \BadMethodCallException("Method [$method] does not exist.");
	}
}