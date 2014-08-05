<?php

namespace Tdd;

class Application
{
	/** @var Factory */
	private $factory;

	public function __construct(Factory $factory)
	{
		$this->factory = $factory;
	}

	public function run($route)
	{
		$routing = array(
			'/' => function() { $this->index(); },
			'/user/register/local' => function() { $this->registerLocalUser(); },
			'/user/register/facebook' => function() { $this->registerExternalUser('facebook'); },
			'/user/register/google' => function() { $this->registerExternalUser('google'); }
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

		$email    = isset($_POST['email']) ? $_POST['email'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';

		if ($registrationModule->registerLocalUser($email, $password))
		{
			echo 'Registered local user successfully!';
		}
		else
		{
			echo 'Registration of local user failed!';
		}
	}

	private function registerExternalUser($type)
	{
		$registrationModule = $this->factory->getRegistrationModule();

		$email    = isset($_POST['email']) ? $_POST['email'] : '';

		if ($registrationModule->registerExternalUser($email, $type))
		{
			echo 'Registered ' . $type . ' user successfully!';
		}
		else
		{
			echo 'Registration of ' . $type . ' user failed!';
		}
	}
}
