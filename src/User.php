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
		$validator = new NonEmptyStringArgumentValidator();

		if (!$validator->isValid($email))
		{
			throw new \InvalidArgumentException('Invalid email!');
		}
		if (!$validator->isValid($password))
		{
			throw new \InvalidArgumentException('Invalid password!');
		}
		if (!$validator->isValid($type))
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
