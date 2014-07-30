<?php

namespace Tdd\Test;

use Tdd\Configuration;
use Tdd\Factory;
use Tdd\EmailValidator;
use Tdd\Key;
use Tdd\PasswordGenerator;
use Tdd\PasswordValidator;
use Tdd\UserValidator;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
	/** @var Configuration */
	private $configuration;
	/** @var Factory */
	private $factory;

	public function setUp()
	{
		$this->configuration = new Configuration();
		$this->factory = new Factory($this->configuration);
	}

	public function setPasswordConfiguration()
	{
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'abc');
	}

	public function testFactoryCanStoreTheConfiguration()
	{
		$this->assertEquals($this->configuration, $this->factory->getConfiguration());
	}

	public function testFactoryCanGetEmailValidator()
	{
		$this->assertTrue($this->factory->getEmailValidator() instanceof EmailValidator);
	}

	public function testFactoryCanGetPasswordValidator()
	{
		$this->setPasswordConfiguration();

		$this->assertTrue($this->factory->getPasswordValidator() instanceof PasswordValidator);
	}

	public function testFactoryCanGetUserValidator()
	{
		$this->setPasswordConfiguration();

		$this->assertTrue($this->factory->getUserValidator() instanceof UserValidator);
	}

	public function testFactoryCanGetPasswordGenerator()
	{
		$this->setPasswordConfiguration();

		$this->assertTrue($this->factory->getPasswordGenerator() instanceof PasswordGenerator);
	}
}
