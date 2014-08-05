<?php

namespace Tdd\Test\Integration;

use Tdd\Application;
use Tdd\Configuration;
use Tdd\Key;
use Tdd\Factory;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{
	/** @var string Temporary database file (copy of the real one) to use for testing. */
	private $databaseFile;
	/** @var Configuration */
	private $configuration;
	/** @var Factory */
	private $factory;
	/** @var Application */
	private $application;

	public function setUp()
	{
		$_GET = $_POST = array();

		// Copy real, empty database file.
		$realDatabaseFile = __DIR__ . '/../../resource/user.db';
		$testDatabaseFile = $realDatabaseFile . '-test';

		if (!file_exists($realDatabaseFile))
		{
			throw new \LogicException('Real database file not found for test!');
		}

		if (file_exists($testDatabaseFile))
		{
			throw new \LogicException('Test database file found for test, but it should not be there...');
		}

		if (!copy($realDatabaseFile, $testDatabaseFile))
		{
			throw new \LogicException('Could not copy real database file to test!');
		}

		$this->databaseFile = $testDatabaseFile;


		// Setup application.
		$this->configuration = new Configuration();

		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'qwertzuiopasdfghjklyxcvbnm');
		$this->configuration->set(Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => $testDatabaseFile));

		$this->factory     = new Factory($this->configuration);
		$this->application = new Application($this->factory);
	}

	public function tearDown()
	{
		unset($this->application, $this->configuration);
		unlink($this->databaseFile);
	}

	public function testLocalUserCanBeRegistered()
	{
		$_POST['email']    = 'user@local.com';
		$_POST['password'] = 'password';

		$this->expectOutputString('Registered local user successfully!');

		$this->application->run('/user/register/local');

		$this->assertNotNull($this->factory->getUserRepository()->getByEmail($_POST['email']));
	}

	public function externalUserInputDataProvider()
	{
		return array(
			array('user@google.com', 'google'),
			array('user@facebook.com', 'facebook')
		);
	}

	/**
	 * @dataProvider externalUserInputDataProvider
	 *
	 * @param string $email
	 * @param string $type
	 */
	public function testExternalUserCanBeRegistered($email, $type)
	{
		$_POST['email'] = $email;

		$this->expectOutputString('Registered ' . $type . ' user successfully!');

		$this->application->run('/user/register/' . $type);

		$this->assertNotNull($this->factory->getUserRepository()->getByEmail($_POST['email']));
	}
}
