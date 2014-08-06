<?php

namespace Tdd\Test\Unit\Module;

use Tdd\Entity\User;
use Tdd\Module\LoginModule;
use Tdd\Repository\UserRepository;
use Tdd\Validator\UserValidator;
use Tdd\Utility\PasswordHasher;

class LoginModuleTest extends \PHPUnit_Framework_TestCase
{
	/** @var UserRepository|\PHPUnit_Framework_MockObject_MockObject */
	private $userRepository;
	/** @var UserValidator|\PHPUnit_Framework_MockObject_MockObject */
	private $userValidator;
	/** @var PasswordHasher|\PHPUnit_Framework_MockObject_MockObject */
	private $passwordHasher;
	/** @var LoginModule */
	private $loginModule;

	/** @var User */
	private $localUser;
	/** @var User */
	private $googleUser;
	/** @var User */
	private $facebookUser;
	/** @var User */
	private $nonExistingUser;

	public function setUp()
	{
		$this->localUser    = new User('user@local.com', 'passwordLocal', 'local');
		$this->googleUser   = new User('user@google.com', 'passwordGoogle', 'google');
		$this->facebookUser = new User('user@facebook.com', 'passwordFacebook', 'facebook');
		$this->nonExistingUser = new User('user@nowhere.com', 'passwordKind', 'local');

		$this->passwordHasher = $this->getMockBuilder('\\Tdd\\Utility\\PasswordHasher')->disableOriginalConstructor()->getMock();
		$this->passwordHasher->expects($this->any())->method('hash')->willReturnArgument(0);

		$this->userRepository = $this->getMockBuilder('\\Tdd\\Repository\\UserRepository')->disableOriginalConstructor()->getMock();
		$this->userRepository->expects($this->any())->method('getByCredentials')->willReturnMap(array(
				array($this->localUser->getEmail(), $this->passwordHasher->hash($this->localUser->getPassword()), $this->localUser),
				array($this->googleUser->getEmail(), $this->passwordHasher->hash($this->googleUser->getPassword()), $this->googleUser),
				array($this->facebookUser->getEmail(), $this->passwordHasher->hash($this->facebookUser->getPassword()), $this->facebookUser),
				array($this->nonExistingUser->getEmail(), $this->passwordHasher->hash($this->nonExistingUser->getPassword()), null)
		));

		$this->userValidator = $this->getMockBuilder('\\Tdd\\Validator\\UserValidator')->disableOriginalConstructor()->getMock();
		$this->userValidator->expects($this->any())->method('isValid')->willReturn(true);

		$this->loginModule = new LoginModule(
			$this->userRepository,
			$this->userValidator,
			$this->passwordHasher
		);
	}

	public function getInvalidLoginModule()
	{
		/** @var UserValidator|\PHPUnit_Framework_MockObject_MockObject $userValidator */
		$userValidator = $this->getMockBuilder('\\Tdd\\Validator\\UserValidator')->disableOriginalConstructor()->getMock();
		$userValidator->expects($this->any())->method('isValid')->willReturn(false);

		return new LoginModule(
			$this->userRepository,
			$userValidator,
			$this->passwordHasher
		);
	}

	public function testUserCanLogin()
	{
		$this->assertEquals($this->localUser, $this->loginModule->loginUser($this->localUser->getEmail(), $this->localUser->getPassword()));
	}

	public function testGoogleUserCanLogin()
	{
		$this->assertEquals($this->googleUser, $this->loginModule->loginUser($this->googleUser->getEmail(), $this->googleUser->getPassword()));
	}

	public function testFacebookUserCanLogin()
	{
		$this->assertEquals($this->facebookUser, $this->loginModule->loginUser($this->facebookUser->getEmail(), $this->facebookUser->getPassword()));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage User details are invalid!
	 */
	public function testInvalidUserCanNotLogin()
	{
		$this->getInvalidLoginModule()->loginUser('email', 'password');
	}

	public function testNonExistingUserCanNotLogin()
	{
		$this->assertNull($this->loginModule->loginUser($this->nonExistingUser->getEmail(), $this->nonExistingUser->getPassword()));
	}
}
