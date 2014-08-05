<?php

namespace Tdd\Test;

use Tdd\Application;
use Tdd\Factory;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
	/** @var Factory|\PHPUnit_Framework_MockObject_MockObject */
	private $factory;
	/** @var Application|\PHPUnit_Framework_MockObject_MockObject */
	private $application;

	public function setUp()
	{
		$_GET = $_POST = $_COOKIE = array();

		$this->factory     = $this->getMockBuilder('\\Tdd\\Factory')->disableOriginalConstructor()->getMock();
		$this->application = new Application($this->factory);
	}

	public function testApplicationCanRunSimpleRequest()
	{
		$this->expectOutputString('Index page');

		$this->application->run('/');
	}


	public function testApplicationDisplaysErrorMessageIfRouteNotFound()
	{
		$this->expectOutputString('Page not found!');

		$this->application->run('/not-found');
	}

	public function userTypeProvider()
	{
		return array(
			array('local', true),
			array('local', false),
			array('google', true),
			array('google', false),
			array('facebook', true),
			array('facebook', false),
		);
	}

	/**
	 * @dataProvider userTypeProvider
	 *
	 * @param string $userType
	 * @param bool   $isValidUser
	 */
	public function testApplicationRegistrationOfUser($userType, $isValidUser)
	{
		$registrationModule = $this->getMockBuilder('\\Tdd\\RegistrationModule')->disableOriginalConstructor()->getMock();

		$_POST['email'] = uniqid('u', true) . '@' . $userType . '.com';

		if ($userType == 'local')
		{
			$_POST['password'] = 'password';

			$registrationModule
				->expects($this->once())
				->method('registerLocalUser')
				->with($_POST['email'], $_POST['password'])
				->willReturn($isValidUser);
		}
		else
		{
			$registrationModule
				->expects($this->once())
				->method('registerExternalUser')
				->with($_POST['email'], $userType)
				->willReturn($isValidUser);
		}

		$this->factory
			->expects($this->once())
			->method('getRegistrationModule')
			->willReturn($registrationModule);

		$this->expectOutputString(
			$isValidUser
			? 'Registered ' . $userType . ' user successfully!'
			: 'Registration of ' . $userType . ' user failed!'
		);

		$this->application->run('/user/register/' . $userType);
	}
}
