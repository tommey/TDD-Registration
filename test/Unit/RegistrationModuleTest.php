<?php

namespace Tdd\Test;

use Tdd\RegistrationModule;
use Tdd\UserRepository;
use Tdd\UserValidator;
use Tdd\PasswordHasher;
use Tdd\PasswordGenerator;

class RegistrationModuleTest extends \PHPUnit_Framework_TestCase
{
	/** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject */
	private $userRepository;
	/** @var UserValidator|\PHPUnit_Framework_MockObject_MockObject */
	private $userValidator;
	/** @var PasswordGenerator|\PHPUnit_Framework_MockObject_MockObject */
	private $passwordGenerator;
	/** @var PasswordHasher|\PHPUnit_Framework_MockObject_MockObject */
	private $passwordHasher;
	/** @var RegistrationModule */
	private $registrationModule;

	public function setUp()
	{
		$this->userRepository = $this->getMockBuilder('\\Tdd\\UserRepository')->disableOriginalConstructor()->getMock();
		$this->userRepository->expects($this->any())->method('save')->willReturn(true);

		$this->userValidator = $this->getMockBuilder('\\Tdd\\UserValidator')->disableOriginalConstructor()->getMock();
		$this->userValidator->expects($this->any())->method('isValid')->willReturn(true);

		$this->passwordGenerator = $this->getMockBuilder('\\Tdd\\PasswordGenerator')->disableOriginalConstructor()->getMock();
		$this->passwordGenerator->expects($this->any())->method('generate')->willReturn('password');

		$this->passwordHasher = $this->getMockBuilder('\\Tdd\\PasswordHasher')->disableOriginalConstructor()->getMock();
		$this->passwordHasher->expects($this->any())->method('hash')->willReturn('abcdef012345789');

		$this->registrationModule = new RegistrationModule(
			$this->userRepository,
			$this->userValidator,
			$this->passwordHasher,
			$this->passwordGenerator
		);
	}

	public function getInvalidRegistrationModule()
	{
		/** @var UserValidator|\PHPUnit_Framework_MockObject_MockObject $userValidator */
		$userValidator = $this->getMockBuilder('\\Tdd\\UserValidator')->disableOriginalConstructor()->getMock();
		$userValidator->expects($this->any())->method('isValid')->willReturn(false);

		return new RegistrationModule(
			$this->userRepository,
			$userValidator,
			$this->passwordHasher,
			$this->passwordGenerator
		);
	}

	public function testLocalUserCanBeRegistered()
	{
		$email    = 'joe@local.com';
		$password = 'abcdef';

		$this->assertTrue($this->registrationModule->registerLocalUser($email, $password));
	}

	public function testExternalFacebookUserCanBeRegistered()
	{
		$email = 'joe@facebook.com';
		$type  = 'facebook';

		$this->assertTrue($this->registrationModule->registerExternalUser($email, $type));
	}

	public function testExternalGoogleUserCanBeRegistered()
	{
		$email = 'joe@google.com';
		$type  = 'google';

		$this->assertTrue($this->registrationModule->registerExternalUser($email, $type));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage User details are invalid!
	 */
	public function testInvalidLocalUserCanNotBeRegistered()
	{
		$this->getInvalidRegistrationModule()->registerLocalUser('email', 'password');
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage User details are invalid!
	 */
	public function testInvalidExternalUserCanNotBeRegistered()
	{
		$this->getInvalidRegistrationModule()->registerExternalUser('email', 'type');
	}
}
