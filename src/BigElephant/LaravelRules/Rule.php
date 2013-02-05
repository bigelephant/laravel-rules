<?php namespace BigElephant\LaravelRules;

use ArrayIterator;
use IteratorAggregate;
use Countable;

class Rule implements IteratorAggregate, Countable {

	/**
	 * Array of laravel rules, as strings.
	 *
	 * @var array
	 */
	protected $rules = array();

	/**
	 * Add a new rule, will turn it into the strings laravel uses
	 *
	 * @param  string $rule
	 * @param  mixed  $params
	 * @return Rule
	 */
	protected function addRule($rule, $params = null)
	{
		$ruleString = $rule;
		if ($params !== null)
		{
			if ( ! is_array($params))
			{
				$params = func_get_args();
				array_shift($params);
			}
			if ( ! empty($params))
			{
				$ruleString .= ':'.implode(',', $params);
			}
		}

		if ( ! in_array($ruleString, $this->rules))
		{
			$this->rules[] = $ruleString;
		}

		return $this;
	}

	/**
	 * This method doesn't do anything, is just to start the chain.
	 *
	 * @return Rule
	 */
	protected function ruleString()
	{
		return $this;
	}

	/**
	 * Validate that a required attribute exists.
	 *
	 * @return Rule
	 */
	protected function ruleRequired()
	{
		return $this->addRule('required');
	}

	/**
	 * Validate that an attribute exists when another attribute exists.
	 *
	 * @param  array $fields
	 * @return Rule
	 */
	protected function ruleRequiredWith($fields)
	{
		$fields = is_array($fields) ? $fields : func_get_args();
		return $this->addRule('requiredWith', $fields);
	}

	/**
	 * Validate that an attribute has a matching confirmation.
	 *
	 * @return Rule
	 */
	protected function ruleConfirmed()
	{
		return $this->addRule('confirmed');
	}

	/**
	 * Validate that two attributes match.
	 *
	 * @param  string $field
	 * @return Rule
	 */
	protected function ruleSame($field)
	{
		return $this->addRule('same', $field);
	}

	/**
	 * Validate that an attribute is different from another attribute.
	 *
	 * @param  string $field
	 * @return Rule
	 */
	protected function ruleDifferent($field)
	{
		return $this->addRule('different', $field);
	}

	/**
	 * Validate that an attribute was "accepted".
	 *
	 * This validation rule implies the attribute is "required".
	 *
	 * @return Rule
	 */
	protected function ruleAccepted()
	{
		return $this->addRule('accepted');
	}

	/**
	 * Validate that an attribute is numeric.
	 *
	 * @return Rule
	 */
	protected function ruleNumeric()
	{
		return $this->addRule('numeric');
	}

	/**
	 * Validate that an attribute is an integer.
	 *
	 * @return Rule
	 */
	protected function ruleInteger()
	{
		return $this->addRule('integer');
	}

	/**
	 * Validate that an attribute has a given number of digits.
	 *
	 * @param  int $length
	 * @return Rule
	 */
	protected function ruleDigits($length)
	{
		return $this->addRule('digits', $length);
	}

	/**
	 * Validate that an attribute is between a given number of digits.
	 *
	 * @param  int $min
	 * @param  int $max
	 * @return Rule
	 */
	protected function ruleDigitsBetween($min, $max)
	{
		return $this->addRule('digitsBetween', $min, $max);
	}

	/**
	 * Validate the size of an attribute.
	 *
	 * @param  int $size
	 * @return Rule
	 */
	protected function ruleSize($size)
	{
		return $this->addRule('size', $size);
	}

	/**
	 * Validate the size of an attribute is between a set of values.
	 *
	 * @param  int $min
	 * @param  int $max
	 * @return Rule
	 */
	protected function ruleBetween($min, $max)
	{
		return $this->addRule('between', $min, $max);
	}
	
	/**
	 * Validate the size of an attribute is greater than a minimum value.
	 *
	 * @param  int $min
	 * @return Rule
	 */
	protected function ruleMin($min)
	{
		return $this->addRule('min', $min);
	}

	/**
	 * Validate the size of an attribute is less than a maximum value.
	 *
	 * @param  int $max
	 * @return Rule
	 */
	protected function ruleMax($max)
	{
		return $this->addRule('max', $max);
	}

	/**
	 * Validate an attribute is contained within a list of values.
	 *
	 * @param  array $fields
	 * @return Rule
	 */
	protected function ruleIn($fields)
	{
		$fields = is_array($fields) ? $fields : func_get_args();
		return $this->addRule('in', $fields);
	}

	/**
	 * Validate an attribute is not contained within a list of values.
	 *
	 * @param  array $fields
	 * @return Rule
	 */
	protected function ruleNotIn($fields)
	{
		$fields = is_array($fields) ? $fields : func_get_args();
		return $this->addRule('notIn', $fields);
	}

	/**
	 * Validate the uniqueness of an attribute value on a given database table.
	 *
	 * If a database column is not specified, the attribute will be used.
	 *
	 * @param  string $table
	 * @param  string $column
	 * @param  int 	  $except
	 * @param  string $idColumn
	 * @return Rule
	 */
	protected function ruleUnique($table, $column = null, $except = null, $idColumn = null)
	{
		return $this->addRule('unique', func_get_args());
	}

	/**
	 * Validate the existence of an attribute value in a database table.
	 *
	 * @param  string $table
	 * @param  string $column
	 * @return Rule
	 */
	protected function ruleExists($table, $column = null)
	{
		return $this->addRule('exists', func_get_args());
	}

	/**
	 * Validate that an attribute is a valid IP.
	 *
	 * @return Rule
	 */
	protected function ruleIp()
	{
		return $this->addRule('ip');
	}

	/**
	 * Validate that an attribute is a valid e-mail address.
	 *
	 * @return Rule
	 */
	protected function ruleEmail()
	{
		return $this->addRule('email');
	}

	/**
	 * Validate that an attribute is a valid URL.
	 *
	 * @return Rule
	 */
	protected function ruleUrl()
	{
		return $this->addRule('url');
	}

	/**
	 * Validate that an attribute is an active URL.
	 *
	 * @return Rule
	 */
	protected function ruleActiveUrl()
	{
		return $this->addRule('activeUrl');
	}

	/**
	 * Validate the MIME type of a file is an image MIME type.
	 *
	 * @return Rule
	 */
	protected function ruleImage()
	{
		return $this->addRule('image');
	}

	/**
	 * Validate the MIME type of a file upload attribute is in a set of MIME types.
	 *
	 * @param  array $mimes
	 * @return Rule
	 */
	protected function ruleMimes($mimes)
	{
		$mimes = is_array($mimes) ? $mimes : func_get_args();
		return $this->addRule('mimes', $mimes);
	}

	/**
	 * Validate that an attribute contains only alphabetic characters.
	 *
	 * @return Rule
	 */
	protected function ruleAlpha()
	{
		return $this->addRule('alpha');
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters.
	 *
	 * @return Rule
	 */
	protected function ruleAlphaNum()
	{
		return $this->addRule('alphaNum');
	}

	/**
	 * Validate that an attribute contains only alpha-numeric characters, dashes, and underscores.
	 *
	 * @return Rule
	 */
	protected function ruleAlphaDash()
	{
		return $this->addRule('alphaDash');
	}

	/**
	 * Validate that an attribute passes a regular expression check.
	 *
	 * @param  string $regex
	 * @return Rule
	 */
	protected function ruleRegex($regex)
	{
		return $this->addRule('regex', $regex);
	}

	/**
	 * Validate that an attribute is a valid date.
	 *
	 * @return Rule
	 */
	protected function ruleDate()
	{
		return $this->addRule('date');
	}

	/**
	 * Validate that an attribute matches a date format.
	 *
	 * @param  string $format
	 * @return Rule
	 */
	protected function ruleDateFormat($format)
	{
		return $this->addRule('dateFormat', $format);
	}

	/**
	 * Validate the date is before a given date.
	 *
	 * @param  string $time
	 * @return Rule
	 */
	protected function ruleBefore($time)
	{
		return $this->addRule('before', $time);
	}

	/**
	 * Validate the date is after a given date.
	 *
	 * @param  string $time
	 * @return Rule
	 */
	protected function ruleAfter($time)
	{
		return $this->addRule('after', $time);
	}

	/**
	 * Iterate through the defined rules.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->rules);
	}

	/**
	 * Count the rules.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->rules);
	}

	/**
	 * Convert the rules to a string that laravel's validator likes.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return implode('|', $this->rules);
	}

	/**
	 * Call a defined rule, if not fallback to adding custom ones. 
	 *
	 * @param  string $method
	 * @param  array  $arguments
	 * @return Rule
	 */
	public function __call($method, $arguments)
	{
		$actualMethod = 'rule'.camel_case($method);
		if (method_exists($this, $actualMethod))
		{
			return call_user_func_array(array($this, $actualMethod), $arguments);
		}

		// Must be a customrule. Note: Everything here could be just done like this but we define
		// all the methods above for those who like auto complete
		return $this->addRule($method, $arguments);
	}
}