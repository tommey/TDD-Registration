<?php

namespace Tdd;

abstract class PersistentStorage extends \PDO
{
	/**
	 * @param string $dsn
	 * @param string $username
	 * @param string $password
	 * @param array  $options
	 */
	public function __construct($dsn, $username = null, $password = null, array $options = array())
	{
		$options[\PDO::ATTR_DEFAULT_FETCH_MODE] = \PDO::FETCH_ASSOC;

		parent::__construct($dsn, $username, $password, $options);
	}
}
