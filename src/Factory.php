<?php

namespace Tdd;

class Factory
{
	/** @var Configuration */
	private $configuration;

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

	public function getEmailValidator()
	{
		return new EmailValidator;
	}

	public function getPasswordValidator()
	{
		return new PasswordValidator(
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH)
		);
	}

	public function getUserValidator()
	{
		return new UserValidator($this->getEmailValidator(), $this->getPasswordValidator());
	}

	public function getPasswordGenerator()
	{
		return new PasswordGenerator(
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH),
			$this->configuration->get(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET)
		);
	}
}
