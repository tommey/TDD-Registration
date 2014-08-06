<?php

namespace Tdd\Test\Unit\Validator;

use Tdd\Validator\NonEmptyStringArgumentValidator;

class NonEmptyStringArgumentValidatorTest extends \PHPUnit_Framework_TestCase
{
	public function testNonEmptyStringArgumentValidatorWorksCorrectly()
	{
		$validator = new NonEmptyStringArgumentValidator();

		$this->assertTrue($validator->isValid('valid'));
		$this->assertTrue($validator->isValid('valid again'));
		$this->assertTrue($validator->isValid('valid again with a' . str_repeat(' long', 100) . ' string'));

		$this->assertFalse($validator->isValid(1));
		$this->assertFalse($validator->isValid(3.14));
		$this->assertFalse($validator->isValid(new \stdClass()));
		$this->assertFalse($validator->isValid(array()));
		$this->assertFalse($validator->isValid(''));
	}
}
