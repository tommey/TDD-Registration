<?php

namespace Tdd;

class Factory
{
	/** @var Configuration */
	private $configuration;

	/**
	 * @param Configuration $configuration
	 */
	public function __construct(Configuration $configuration)
	{
		$this->configuration = $configuration;
	}

	/**
	 * @return Configuration
	 */
	public function getConfiguration()
	{
		return $this->configuration;
	}

	/**
	 * @return EmailValidator
	 */
	public function getEmailValidator()
	{
		return new EmailValidator;
	}

	/**
	 * @return PasswordValidator
	 */
	public function getPasswordValidator()
	{
		return new PasswordValidator(
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH)
		);
	}

	/**
	 * @return UserTypeValidator
	 */
	public function getUserTypeValidator()
	{
		return new UserTypeValidator();
	}

	/**
	 * @return UserValidator
	 */
	public function getUserValidator()
	{
		return new UserValidator(
			$this->getEmailValidator(),
			$this->getPasswordValidator(),
			$this->getUserTypeValidator()
		);
	}

	/**
	 * @return PasswordGenerator
	 */
	public function getPasswordGenerator()
	{
		return new PasswordGenerator(
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET)
		);
	}

	/**
	 * @return PasswordHasher
	 */
	public function getPasswordHasher()
	{
		return new PasswordHasher();
	}

	/**
	 * @return SqliteStorage
	 */
	public function getUserPersistentStorage()
	{
		return new SqliteStorage($this->configuration->get(Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION));
	}

	/**
	 * @return UserRepository
	 */
	public function getUserRepository()
	{
		return new UserRepository($this->getUserPersistentStorage());
	}

	/**
	 * @return RegistrationModule
	 */
	public function getRegistrationModule()
	{
		return new RegistrationModule(
			$this->getUserRepository(),
			$this->getUserValidator(),
			$this->getPasswordHasher(),
			$this->getPasswordGenerator()
		);
	}
}
