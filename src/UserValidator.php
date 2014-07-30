<?php

namespace Tdd;

class UserValidator implements IValidator
{
	/** @var EmailValidator */
	private $emailValidator;
	/** @var PasswordValidator */
	private $passwordValidator;

	public function __construct($emailValidator, $passwordValidator)
	{
		$this->emailValidator    = $emailValidator;
		$this->passwordValidator = $passwordValidator;
	}

	public function isValid($user)
	{
		if (!($user instanceof User))
		{
			throw new \InvalidArgumentException('Invalid user!');
		}

		return $this->emailValidator->isValid($user->getEmail()) && $this->passwordValidator->isValid($user->getPassword());
	}
}
