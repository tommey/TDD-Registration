<?php

namespace Tdd\Module;

use Tdd\Entity\User;
use Tdd\Repository\UserRepository;
use Tdd\Utility\PasswordGenerator;
use Tdd\Utility\PasswordHasher;
use Tdd\Validator\UserValidator;

class RegistrationModule
{
	/** @var UserValidator */
	private $userValidator;
	/** @var UserRepository */
	private $userRepository;
	/** @var PasswordHasher */
	private $passwordHasher;
	/** @var PasswordGenerator */
	private $passwordGenerator;

	/**
	 * @param UserRepository    $userRepository
	 * @param UserValidator     $userValidator
	 * @param PasswordHasher    $passwordHasher
	 * @param PasswordGenerator $passwordGenerator
	 */
	public function __construct(
		UserRepository $userRepository,
		UserValidator $userValidator,
		PasswordHasher $passwordHasher,
		PasswordGenerator $passwordGenerator
	) {
		$this->userRepository    = $userRepository;
		$this->userValidator     = $userValidator;
		$this->passwordHasher    = $passwordHasher;
		$this->passwordGenerator = $passwordGenerator;
	}

	/**
	 * @param string $email
	 * @param string $password
	 *
	 * @return bool
	 */
	public function registerLocalUser($email, $password)
	{
		return $this->registerUser($email, $password, 'local');
	}

	/**
	 * @param string $email
	 * @param string $type
	 *
	 * @return bool
	 */
	public function registerExternalUser($email, $type)
	{
		return $this->registerUser($email, $this->passwordGenerator->generate(), $type);
	}

	/**
	 * @param string $email
	 * @param string $password
	 * @param string $type
	 *
	 * @return bool
	 */
	private function registerUser($email, $password, $type)
	{
		$rawUser = new User($email, $password, $type);

		if (!$this->userValidator->isValid($rawUser))
		{
			throw new \InvalidArgumentException('User details are invalid!');
		}

		$encodedUser = new User($email, $this->passwordHasher->hash($password), $type);

		return $this->userRepository->save($encodedUser);
	}
}
