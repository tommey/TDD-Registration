<?php

namespace Tdd;

class UserValidator implements IValidator
{
	/** @var EmailValidator */
	private $emailValidator;
	/** @var PasswordValidator */
	private $passwordValidator;
	/** @var UserTypeValidator */
	private $userTypeValidator;

	public function __construct($emailValidator, $passwordValidator, $userTypeValidator)
	{
		$this->emailValidator    = $emailValidator;
		$this->passwordValidator = $passwordValidator;
		$this->userTypeValidator = $userTypeValidator;
	}

	public function isValid($user)
	{
		if (!($user instanceof User))
		{
			throw new \InvalidArgumentException('Invalid user!');
		}

		return
			$this->emailValidator->isValid($user->getEmail())
			&& $this->passwordValidator->isValid($user->getPassword())
			&& $this->userTypeValidator->isValid($user->getType())
		;
	}
}
