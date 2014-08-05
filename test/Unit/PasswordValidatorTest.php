<?php

namespace Tdd\Test;

use Tdd\PasswordValidator;

class PasswordValidatorTest extends \PHPUnit_Framework_TestCase
{
	/** @var PasswordValidator */
	private $passwordValidator;

	const PASSWORD_MINIMUM_LENGTH = 6;
	const PASSWORD_MAXIMUM_LENGTH = 64;

	public function setUp()
	{
		$this->passwordValidator = new PasswordValidator(self::PASSWORD_MINIMUM_LENGTH, self::PASSWORD_MAXIMUM_LENGTH);
	}

	public function testPasswordValidatorValidatesValidPasswordCorrectly()
	{
		$this->assertTrue($this->passwordValidator->isValid('abcdef'));
		$this->assertTrue($this->passwordValidator->isValid('abcdef0123456789'));
		$this->assertTrue($this->passwordValidator->isValid('abcdef0123456789áéúőűóü'));
		$this->assertTrue($this->passwordValidator->isValid('abcdef0123456789áéúőűóü,.-?:_+!%/=(")'));
		$this->assertTrue($this->passwordValidator->isValid(str_repeat('a', self::PASSWORD_MAXIMUM_LENGTH)));
	}

	public function testPasswordValidatorDoesNotValidateInvalidPasswords()
	{
		$this->assertFalse($this->passwordValidator->isValid(0));
		$this->assertFalse($this->passwordValidator->isValid('abc'));
		$this->assertFalse($this->passwordValidator->isValid(str_repeat('a', self::PASSWORD_MAXIMUM_LENGTH + 1)));
	}
}
