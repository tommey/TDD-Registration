<?php

namespace Tdd\Common;

use Tdd\Entity\User;

class Application
{
	/** @var Factory */
	private $factory;

	/**
	 * @param Factory $factory
	 */
	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	/**
	 * @param string $route
	 */
	public function run($route)
	{
		$routing = array(
			'/' => function() { $this->index(); },
			'/user/register/local' => function() { $this->registerLocalUser(); },
			'/user/register/facebook' => function() { $this->registerExternalUser('facebook'); },
			'/user/register/google' => function() { $this->registerExternalUser('google'); },
			'/user/login' => function() { $this->loginUser(); }
		);

		if (isset($routing[$route]))
		{
			$routing[$route]();
		}
		else
		{
			echo 'Page not found!';
		}
	}

	private function index()
	{
		echo 'Index page';
	}

	private function registerLocalUser()
	{
		$registrationModule = $this->factory->getRegistrationModule();

		$email    = isset($_POST[Key::POST_PARAMETER_USER_EMAIL]) ? $_POST[Key::POST_PARAMETER_USER_EMAIL] : '';
		$password = isset($_POST[Key::POST_PARAMETER_USER_PASSWORD]) ? $_POST[Key::POST_PARAMETER_USER_PASSWORD] : '';

		if ($registrationModule->registerLocalUser($email, $password))
		{
			echo 'Registered local user successfully!';
		}
		else
		{
			echo 'Registration of local user failed!';
		}
	}

	/**
	 * @param string $type
	 */
	private function registerExternalUser($type)
	{
		$registrationModule = $this->factory->getRegistrationModule();

		$email = isset($_POST[Key::POST_PARAMETER_USER_EMAIL]) ? $_POST[Key::POST_PARAMETER_USER_EMAIL] : '';

		if ($registrationModule->registerExternalUser($email, $type))
		{
			echo 'Registered ' . $type . ' user successfully!';
		}
		else
		{
			echo 'Registration of ' . $type . ' user failed!';
		}
	}

	private function loginUser()
	{
		$loginModule = $this->factory->getLoginModule();

		$email    = isset($_POST[Key::POST_PARAMETER_USER_EMAIL]) ? $_POST[Key::POST_PARAMETER_USER_EMAIL] : '';
		$password = isset($_POST[Key::POST_PARAMETER_USER_PASSWORD]) ? $_POST[Key::POST_PARAMETER_USER_PASSWORD] : '';

		$user = $loginModule->loginUser($email, $password);

		if ($user instanceof User)
		{
			echo 'Logged in!';
		}
		else
		{
			echo 'Login failed!';
		}
	}
}
