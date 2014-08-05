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

	/**
	 * @param EmailValidator    $emailValidator
	 * @param PasswordValidator $passwordValidator
	 * @param UserTypeValidator $userTypeValidator
	 */
	public function __construct(EmailValidator $emailValidator, PasswordValidator $passwordValidator, UserTypeValidator $userTypeValidator)
	{
		$this->emailValidator    = $emailValidator;
		$this->passwordValidator = $passwordValidator;
		$this->userTypeValidator = $userTypeValidator;
	}

	/**
	 * @param User $user
	 *
	 * @return bool
	 */
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
