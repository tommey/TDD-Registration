<?php

namespace Tdd\Test\Unit;

use Tdd\Configuration;
use Tdd\Factory;
use Tdd\EmailValidator;
use Tdd\Key;
use Tdd\PasswordGenerator;
use Tdd\PasswordHasher;
use Tdd\PasswordValidator;
use Tdd\RegistrationModule;
use Tdd\SqliteStorage;
use Tdd\UserRepository;
use Tdd\UserTypeValidator;
use Tdd\UserValidator;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
	/** @var Configuration */
	private $configuration;
	/** @var Factory */
	private $factory;

	private $databaseFile;

	public function __construct()
	{
		$this->databaseFile = __DIR__ . '/user.db';
	}

	public function setUp()
	{
		$this->configuration = new Configuration();
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'abc');
		$this->configuration->set(Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => $this->databaseFile));

		$this->factory = new Factory($this->configuration);
	}

	public function tearDown()
	{
		file_exists($this->databaseFile) and unlink($this->databaseFile);
	}

	public function testFactoryCanGetConfiguration()
	{
		$this->assertTrue($this->factory->getConfiguration() instanceof Configuration);
		$this->assertEquals($this->configuration, $this->factory->getConfiguration());
	}

	public function testFactoryCanGetEmailValidator()
	{
		$this->assertTrue($this->factory->getEmailValidator() instanceof EmailValidator);
	}

	public function testFactoryCanGetPasswordGenerator()
	{
		$this->assertTrue($this->factory->getPasswordGenerator() instanceof PasswordGenerator);
	}

	public function testFactoryCanGetPasswordHasher()
	{
		$this->assertTrue($this->factory->getPasswordHasher() instanceof PasswordHasher);
	}

	public function testFactoryCanGetPasswordValidator()
	{
		$this->assertTrue($this->factory->getPasswordValidator() instanceof PasswordValidator);
	}

	public function testFactoryCanGetRegistrationModule()
	{
		$this->assertTrue($this->factory->getRegistrationModule() instanceof RegistrationModule);
	}

	public function testFactoryCanGetUserPersistentStorage()
	{
		$this->assertTrue($this->factory->getUserPersistentStorage() instanceof SqliteStorage);
	}

	public function testFactoryCanGetUserRepository()
	{
		$this->assertTrue($this->factory->getUserRepository() instanceof UserRepository);
	}

	public function testFactoryCanGetUserTypeValidator()
	{
		$this->assertTrue($this->factory->getUserTypeValidator() instanceof UserTypeValidator);
	}

	public function testFactoryCanGetUserValidator()
	{
		$this->assertTrue($this->factory->getUserValidator() instanceof UserValidator);
	}
}
