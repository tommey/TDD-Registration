<?php

namespace Tdd\Test\Unit;

use Tdd\PasswordHasher;

class PasswordHasherTest extends \PHPUnit_Framework_TestCase
{
	public function testPasswordHasherCreatesHexaHash()
	{
		$passwordHasher = new PasswordHasher();

		$this->assertRegExp('/^[0-9a-f]{32,}$/i', $passwordHasher->hash('password'));
	}
}
