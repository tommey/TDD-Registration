<?php

namespace Tdd\Cache;

interface ICacheStorage
{
	/**
	 * @param string $key
	 * @param mixed  $value
	 * @param int    $ttl
	 *
	 * @return bool
	 */
	public function set($key, $value, $ttl);

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get($key);
}
