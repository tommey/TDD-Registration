<?php

namespace Tdd;

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

	public function registerLocalUser($email, $password)
	{
		return $this->registerUser($email, $password, 'local');
	}

	public function registerExternalUser($email, $type)
	{
		return $this->registerUser($email, $this->passwordGenerator->generate(), $type);
	}

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
