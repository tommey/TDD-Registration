<?php

namespace Tdd\Test;

use Tdd\EmailValidator;
use Tdd\PasswordValidator;
use Tdd\UserTypeValidator;
use Tdd\UserValidator;
use Tdd\User;

class UserValidatorTest extends \PHPUnit_Framework_TestCase
{
	/** @var EmailValidator|\PHPUnit_Framework_MockObject_MockObject */
	private $emailValidator;
	/** @var PasswordValidator|\PHPUnit_Framework_MockObject_MockObject */
	private $passwordValidator;
	/** @var UserTypeValidator|\PHPUnit_Framework_MockObject_MockObject */
	private $userTypeValidator;
	/** @var UserValidator */
	private $userValidator;

	public function setUp()
	{
		$this->emailValidator = $this->getMock('\\Tdd\\EmailValidator');
		$this->emailValidator->expects($this->any())->method('isValid')->willReturn(true);

		$this->passwordValidator = $this->getMock('\\Tdd\\PasswordValidator', array(), array(), '', false);
		$this->passwordValidator->expects($this->any())->method('isValid')->willReturn(true);

		$this->userTypeValidator = $this->getMock('\\Tdd\\UserTypeValidator');
		$this->userTypeValidator->expects($this->any())->method('isValid')->willReturn(true);

		$this->userValidator = new UserValidator(
			$this->emailValidator,
			$this->passwordValidator,
			$this->userTypeValidator
		);
	}

	public function testUserValidatorCanValidateValidUser()
	{
		$user = new User('email@address.com', 'password', 'local');

		$this->assertTrue($this->userValidator->isValid($user));
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testUserValidatorThrowsInvalidArgumentExceptionForNonUserParameter()
	{
		$this->userValidator->isValid("This is not a user object");
	}
}
