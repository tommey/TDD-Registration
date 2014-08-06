<?php

namespace Tdd\Utility;

class PasswordHasher
{
	/**
	 * @param string $password
	 *
	 * @return string
	 */
	public function hash($password)
	{
		return sha1($password);
	}
}
