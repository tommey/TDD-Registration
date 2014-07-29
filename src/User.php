<?php

namespace Tdd;

class User
{
	private $email;
	private $password;

	public function __construct($email, $password)
	{
		if (!is_string($email) || empty($email))
		{
			throw new \InvalidArgumentException('Invalid email!');
		}
		if (!is_string($password) || empty($password))
		{
			throw new \InvalidArgumentException('Invalid password!');
		}

		$this->email = (string)$email;
		$this->password = (string)$password;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
}
