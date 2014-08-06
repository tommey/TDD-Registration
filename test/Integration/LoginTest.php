<?php

namespace Tdd\Test\Integration;

use Tdd\Common\Application;
use Tdd\Common\Configuration;
use Tdd\Common\Key;
use Tdd\Common\Factory;
use Tdd\Entity\User;

class LoginTest extends \PHPUnit_Framework_TestCase
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

		$this->setUpDatabase();
		$this->setUpConfiguration();

		$this->factory     = new Factory($this->configuration);
		$this->application = new Application($this->factory);

		$this->setUpRegisteredUsersInDatabase();
	}

	public function tearDown()
	{
		unset($this->application, $this->configuration);
		unlink($this->databaseFile);
	}

	/**
	 * @return array
	 */
	public function externalUserInputDataProvider()
	{
		return array(
			array('user@local.com', 'passwordLocal', 'local'),
			array('user@google.com', 'passwordGoogle', 'google'),
			array('user@facebook.com', 'passwordFacebook', 'facebook')
		);
	}

	/**
	 * @dataProvider externalUserInputDataProvider
	 *
	 * @param string $email
	 * @param string $password
	 */
	public function testEveryUserTypeCanLogin($email, $password)
	{
		$_POST['email']    = $email;
		$_POST['password'] = $password;

		$this->expectOutputString('Logged in!');

		$this->application->run('/user/login');
	}

	private function setUpDatabase()
	{
		// Copy real, empty database file.
		$realDatabaseFile = __DIR__ . '/../../resource/user.db';
		$testDatabaseFile = $realDatabaseFile . '-test';

		if (!file_exists($realDatabaseFile)) {
			throw new \LogicException('Real database file not found for test!');
		}

		if (file_exists($testDatabaseFile)) {
			throw new \LogicException('Test database file found for test, but it should not be there...');
		}

		if (!copy($realDatabaseFile, $testDatabaseFile)) {
			throw new \LogicException('Could not copy real database file to test!');
		}

		$this->databaseFile = $testDatabaseFile;
	}

	private function setUpConfiguration()
	{
		$this->configuration = new Configuration();

		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'qwertzuiopasdfghjklyxcvbnm');
		$this->configuration->set(Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => $this->databaseFile));
	}

	private function setUpRegisteredUsersInDatabase()
	{
		$passwordHasher = $this->factory->getPasswordHasher();
		$userRepository = $this->factory->getUserRepository();
		foreach ($this->externalUserInputDataProvider() as $user)
		{
			if (false === $userRepository->save(new User($user[0], $passwordHasher->hash($user[1]), $user[2])))
			{
				throw new \LogicException('Could not setup database for login integration test!');
			}
		}
	}
}
