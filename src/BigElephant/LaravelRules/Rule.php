<?php namespace BigElephant\LaravelRules;

use ArrayIterator;
use IteratorAggregate;
use Countable;

class Rule implements IteratorAggregate, Countable {

	protected $rules = array();

	protected function addRule($rule, $params = null)
	{
		$ruleString = $rule;
		if ($params !== null)
		{
			$params = is_array($params) ? $params : func_get_args();
			$ruleString .= ':'.implode(',', $params);
		}

		if ( ! in_array($ruleString, $this->rules))
		{
			$this->rules[] = $ruleString;
		}
	}

	protected function ruleString()
	{
		return $this;
	}

	protected function ruleRequired()
	{
		$this->addRule('required');

		return $this;
	}

	protected function ruleRequiredWith($params)
	{
		$params = is_array($params) ? $params : func_get_args();
		$this->addRule('requiredWith', $params);

		return $this;
	}

	protected function ruleConfirmed()
	{
		$this->addRule('confirmed');

		return $this;
	}

	protected function ruleSame($field)
	{
		$this->addRule('same', $field);

		return $this;
	}

	protected function ruleDifferent($field)
	{
		$this->addRule('different', $field);

		return $this;
	}

	protected function ruleAccepted()
	{
		$this->addRule('accepted');

		return $this;
	}

	protected function ruleNumeric()
	{
		$this->addRule('numeric');

		return $this;
	}

	protected function ruleInteger()
	{
		$this->addRule('integer');

		return $this;
	}

	protected function ruleDigits($length)
	{
		$this->addRule('digits', $length);

		return $this;
	}

	protected function ruleDigitsBetween($min, $max)
	{
		$this->addRule('digitsBetween', $min, $max);

		return $this;
	}

	protected function ruleSize($size)
	{
		$this->addRule('size', $size);

		return $this;
	}

	protected function ruleBetween($min, $max)
	{
		$this->addRule('between', $min, $max);

		return $this;
	}
	
	protected function ruleMin($min)
	{
		$this->addRule('min', $min);

		return $this;
	}

	protected function ruleMax($max)
	{
		$this->addRule('max', $max);

		return $this;
	}

	protected function ruleIn($params)
	{
		$params = is_array($params) ? $params : func_get_args();
		$this->addRule('in', $params);

		return $this;
	}

	protected function ruleNotIn($params)
	{
		$params = is_array($params) ? $params : func_get_args();
		$this->addRule('notIn', $params);

		return $this;
	}

	protected function ruleUnique($table, $column = null, $except = null, $idColumn = null)
	{
		$this->addRule('unique', func_get_args());

		return $this;
	}

	protected function ruleExists($table, $column = null)
	{
		$this->addRule('exists', func_get_args());

		return $this;
	}

	protected function ruleIp()
	{
		$this->addRule('ip');

		return $this;
	}

	protected function ruleEmail()
	{
		$this->addRule('email');

		return $this;
	}

	protected function ruleUrl()
	{
		$this->addRule('url');

		return $this;
	}

	protected function ruleActiveUrl()
	{
		$this->addRule('activeUrl');

		return $this;
	}

	protected function ruleImage()
	{
		$this->addRule('image');

		return $this;
	}

	protected function ruleMimes($params)
	{
		$params = is_array($params) ? $params : func_get_args();
		$this->addRule('mimes', $params);

		return $this;
	}

	protected function ruleAlpha()
	{
		$this->addRule('alpha');

		return $this;
	}

	protected function ruleAlphaNum()
	{
		$this->addRule('alphaNum');

		return $this;
	}

	protected function ruleAlphaDash()
	{
		$this->addRule('alphaDash');

		return $this;
	}

	protected function ruleRegex($regex)
	{
		$this->addRule('regex', $regex);

		return $this;
	}

	protected function ruleDate()
	{
		$this->addRule('date');

		return $this;
	}

	protected function ruleDateFormat($format)
	{
		$this->addRule('dateFormat', $format);

		return $this;
	}

	protected function ruleBefore($time)
	{
		$this->addRule('before', $time);

		return $this;
	}

	protected function ruleAfter($time)
	{
		$this->addRule('after', $time);

		return $this;
	}

	public function getIterator()
	{
		return new ArrayIterator($this->rules);
	}

	public function count()
	{
		return count($this->rules);
	}

	public function __toString()
	{
		return implode('|', $this->rules);
	}

	public function __call($method, $arguments)
	{
		$actualMethod = 'rule'.camel_case($method);
		if (method_exists($this, $actualMethod))
		{
			return call_user_func_array(array($this, $actualMethod), $arguments);
		}

		// Must be a customrule. Note: Everything here could be just done like this but we define
		// all the methods above for those who like auto complete
		$this->addRule($method, $arguments);

		return $this;
	}
}