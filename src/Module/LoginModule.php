<?php

namespace Tdd\Module;

use Tdd\Entity\User;
use Tdd\Repository\UserRepository;
use Tdd\Utility\PasswordHasher;
use Tdd\Validator\UserValidator;

class LoginModule
{
	/** @var UserValidator */
	private $userValidator;
	/** @var UserRepository */
	private $userRepository;
	/** @var PasswordHasher */
	private $passwordHasher;

	/**
	 * @param UserRepository    $userRepository
	 * @param UserValidator     $userValidator
	 * @param PasswordHasher    $passwordHasher
	 */
	public function __construct(
		UserRepository $userRepository,
		UserValidator $userValidator,
		PasswordHasher $passwordHasher
	) {
		$this->userRepository    = $userRepository;
		$this->userValidator     = $userValidator;
		$this->passwordHasher    = $passwordHasher;
	}

	/**
	 * @param string $email
	 * @param string $password
	 *
	 * @return null|User
	 */
	public function loginUser($email, $password)
	{
		$rawUser = new User($email, $password, 'local');

		if (!$this->userValidator->isValid($rawUser))
		{
			throw new \InvalidArgumentException('User details are invalid!');
		}

		return $this->userRepository->getByCredentials($email, $this->passwordHasher->hash($password));
	}
}
