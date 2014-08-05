<?php

namespace Tdd;

class User
{
	/** @var string */
	private $email;
	/** @var string */
	private $password;
	/** @var string */
	private $type;

	/**
	 * @param string $email
	 * @param string $password
	 * @param string $type
	 */
	public function __construct($email, $password, $type)
	{
		if (!is_string($email) || empty($email))
		{
			throw new \InvalidArgumentException('Invalid email!');
		}
		if (!is_string($password) || empty($password))
		{
			throw new \InvalidArgumentException('Invalid password!');
		}
		if (!is_string($type) || empty($type))
		{
			throw new \InvalidArgumentException('Invalid type!');
		}

		$this->email    = $email;
		$this->password = $password;
		$this->type     = $type;
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

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}
}
