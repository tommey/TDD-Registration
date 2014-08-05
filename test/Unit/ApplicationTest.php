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

	public function testApplicationCanRegisterValidLocalUser()
	{
		$registrationModule = $this->getMock('\\Tdd\\RegistrationModule', array(), array(), '', false);

		$_POST['email']    = uniqid('u', true) . '@local.com';
		$_POST['password'] = 'password';
		$registrationModule->expects($this->once())->method('registerLocalUser')->with($_POST['email'], $_POST['password'])->willReturn(true);

		$this->factory->expects($this->once())->method('getRegistrationModule')->willReturn($registrationModule);

		$this->expectOutputString('Registered local user successfully!');

		$this->application->run('/user/register/local');
	}

	public function testApplicationCanNotRegisterInvalidLocalUser()
	{
		$registrationModule = $this->getMock('\\Tdd\\RegistrationModule', array(), array(), '', false);

		$_POST['email']    = uniqid('u', true) . '@local.com';
		$_POST['password'] = 'password';
		$registrationModule->expects($this->once())->method('registerLocalUser')->with($_POST['email'], $_POST['password'])->willReturn(false);

		$this->factory->expects($this->once())->method('getRegistrationModule')->willReturn($registrationModule);

		$this->expectOutputString('Registration of local user failed!');

		$this->application->run('/user/register/local');
	}

	public function externalUserTypeProvider()
	{
		return array(
			array('google'),
			array('facebook'),
		);
	}

	/**
	 * @dataProvider externalUserTypeProvider
	 *
	 * @param string $externalUserType
	 */
	public function testApplicationCanRegisterValidExternalUser($externalUserType)
	{
		$registrationModule = $this->getMockBuilder('\\Tdd\\RegistrationModule')->disableOriginalConstructor()->getMock();

		$_POST['email'] = uniqid('u', true) . '@' . $externalUserType . '.com';

		$registrationModule
			->expects($this->once())
			->method('registerExternalUser')
			->with($_POST['email'], $externalUserType)
			->willReturn(true);

		$this->factory
			->expects($this->once())
			->method('getRegistrationModule')
			->willReturn($registrationModule);

		$this->expectOutputString('Registered ' . $externalUserType . ' user successfully!');

		$this->application->run('/user/register/' . $externalUserType);
	}

	/**
	 * @dataProvider externalUserTypeProvider
	 *
	 * @param string $externalUserType
	 */
	public function testApplicationCanNotRegisterInvalidExternalUser($externalUserType)
	{
		$registrationModule = $this->getMockBuilder('\\Tdd\\RegistrationModule')->disableOriginalConstructor()->getMock();

		$_POST['email'] = uniqid('u', true) . '@' . $externalUserType . '.com';

		$registrationModule
			->expects($this->once())
			->method('registerExternalUser')
			->with($_POST['email'], $externalUserType)
			->willReturn(false);

		$this->factory
			->expects($this->once())
			->method('getRegistrationModule')
			->willReturn($registrationModule);

		$this->expectOutputString('Registration of ' . $externalUserType . ' user failed!');

		$this->application->run('/user/register/' . $externalUserType);
	}
}
