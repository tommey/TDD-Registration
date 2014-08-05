<?php

namespace Tdd;

class Configuration
{
	private $data = array();

	/**
	 * @param string $key
	 * @param mixed  $value
	 */
	public function set($key, $value)
	{
		if (!is_string($key) || empty($key))
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
