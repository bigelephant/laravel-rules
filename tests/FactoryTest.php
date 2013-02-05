<?php

use BigElephant\LaravelRules\Factory;
use BigElephant\LaravelRules\Rule;

class FactoryTest extends PHPUnit_Framework_TestCase {

	public function testMakeRules()
	{
		$factory = new Factory;

		$this->assertTrue($factory->required() instanceof Rule);
		$this->assertTrue($factory->anything() instanceof Rule);
	}
}