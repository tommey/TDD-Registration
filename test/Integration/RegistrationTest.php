<?php

namespace Tdd\Test\Integration;

use Tdd\Application;
use Tdd\Configuration;
use Tdd\Key;
use Tdd\Factory;

class RegistrationTest extends \PHPUnit_Framework_TestCase
{
	/** @var Configuration */
	private $configuration;
	/** @var Factory */
	private $factory;
	/** @var Application */
	private $application;

	public function setUp()
	{
		$_GET = $_POST = array();

		$this->configuration = new Configuration();

		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
		$this->configuration->set(Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'qwertzuiopasdfghjklyxcvbnm');
		$this->configuration->set(Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => __DIR__ . '/../../resource/user.db'));

		$this->factory     = new Factory($this->configuration);
		$this->application = new Application($this->factory);
	}

	public function tearDown()
	{
		unset($this->application, $this->configuration);
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
