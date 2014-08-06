<?php

namespace Tdd\Common;

use Tdd\Validator\IValidator;
use Tdd\Validator\NonEmptyStringArgumentValidator;

class Configuration
{
	/** @var array */
	private $data = array();
	/** @var IValidator */
	private $keyValidator;

	public function __construct()
	{
		$this->keyValidator = new NonEmptyStringArgumentValidator();
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		if (!$this->keyValidator->isValid($key))
		{
			throw new \InvalidArgumentException('Key must be a non-empty string!');
		}

		$this->data[$key] = $value;
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get($key)
	{
		return
			isset($this->data[$key])
			? $this->data[$key]
			: null
		;
	}
}
