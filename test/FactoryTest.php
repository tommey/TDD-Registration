<?php

namespace Tdd\Test;

use Tdd\Configuration;
use Tdd\Factory;
use Tdd\EmailValidator;
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
		$this->configuration->set('validation.user.password.minimum_length', 6);
		$this->configuration->set('validation.user.password.maximum_length', 64);
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
}
