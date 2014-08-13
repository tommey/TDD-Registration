<?php

namespace Tdd\Cache;

class MemcacheCacheStorage implements ICacheStorage
{
	/** @var \Memcache */
	private $memcache;

	/**
	 * @param \Memcache $memcache
	 */
	public function __construct(\Memcache $memcache)
	{
		$this->memcache = $memcache;
	}

	/**
	 * @param string $key
	 * @param mixed  $value
	 * @param int    $ttl
	 *
	 * @return bool
	 */
	public function set($key, $value, $ttl = 0)
	{
		return $this->memcache->set($key, $value, 0, $ttl);
	}

	/**
	 * @param string $key
	 *
	 * @return mixed
	 */
	public function get($key)
	{
		// MemcachePool required argument, but we don't need it.
		$flags = 0;

		return $this->memcache->get($key, $flags);
	}
}
