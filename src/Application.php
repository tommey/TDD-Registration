<?php

namespace Tdd;

class Application
{
	/** @var Factory */
	private $factory;

	public function __construct($factory)
	{
		$this->factory = $factory;
	}

	public function run($route)
	{
		switch ($route)
		{
			case '/':
				echo 'Index page';
				break;

			case '/user/register/local':
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
				break;

			case '/user/register/facebook':
				$registrationModule = $this->factory->getRegistrationModule();

				$email    = isset($_POST['email']) ? $_POST['email'] : '';

				if ($registrationModule->registerExternalUser($email, 'facebook'))
				{
					echo 'Registered facebook user successfully!';
				}
				else
				{
					echo 'Registration of facebook user failed!';
				}
				break;

			case '/user/register/google':
				$registrationModule = $this->factory->getRegistrationModule();

				$email    = isset($_POST['email']) ? $_POST['email'] : '';

				if ($registrationModule->registerExternalUser($email, 'google'))
				{
					echo 'Registered google user successfully!';
				}
				else
				{
					echo 'Registration of google user failed!';
				}
				break;

			default:
				echo 'Page not found!';
				break;
		}
	}
}