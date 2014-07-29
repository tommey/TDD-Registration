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
			$this->configuration->get('validation.user.password.minimum_length'),
			$this->configuration->get('validation.user.password.maximum_length')
		);
	}

	public function getUserValidator()
	{
		return new UserValidator($this->getEmailValidator(), $this->getPasswordValidator());
	}
}
