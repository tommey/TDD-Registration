<?php

namespace Tdd\Test\Unit;

use Tdd\EmailValidator;

class EmailValidatorTest extends \PHPUnit_Framework_TestCase
{
	/** @var EmailValidator */
	private $emailValidator;

	public function setUp()
	{
		$this->emailValidator = new EmailValidator();
	}

	public function testEmailValidatorValidatesValidEmailCorrectly()
	{
		$this->assertTrue($this->emailValidator->isValid('email@address.com'));
	}

	public function testEmailValidatorDoesNotValidateInvalidEmail()
	{
		$this->assertFalse($this->emailValidator->isValid('email'));
		$this->assertFalse($this->emailValidator->isValid('email@valid-com'));
		$this->assertFalse($this->emailValidator->isValid('email-valid.com'));
	}
}
