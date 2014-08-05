<?php

namespace Tdd\Test;

use Tdd\UserTypeValidator;

class UserTypeValidatorTest extends \PHPUnit_Framework_TestCase
{
	/** @var UserTypeValidator */
	private $userTypeValidator;

	public function setUp()
	{
		$this->userTypeValidator = new UserTypeValidator();
	}

	public function testUserTypeValidatorValidatesValidUserTypeCorrectly()
	{
		$this->assertTrue($this->userTypeValidator->isValid('local'));
		$this->assertTrue($this->userTypeValidator->isValid('facebook'));
		$this->assertTrue($this->userTypeValidator->isValid('google'));
	}

	public function testUserTypeValidatorDoesNotValidateInvalidUserType()
	{
		$this->assertFalse($this->userTypeValidator->isValid('invalid'));
		$this->assertFalse($this->userTypeValidator->isValid(0));
		$this->assertFalse($this->userTypeValidator->isValid(array()));
	}
}
