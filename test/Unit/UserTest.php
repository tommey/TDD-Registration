<?php

namespace Tdd\Test\Unit;

use Tdd\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
	public function testUserCanStoreEmailAndPasswordAndType()
	{
		$email = "email@email.com";
		$password = "password";
		$type = 'type';

		$user = new User($email, $password, $type);

		$this->assertEquals($email, $user->getEmail());
		$this->assertEquals($password, $user->getPassword());
		$this->assertEquals($type, $user->getType());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid email!
	 */
	public function testUserThrowsExceptionForNonStringEmail()
	{
		new User(0, 0, 0);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid password!
	 */
	public function testUserThrowsExceptionForNonStringPassword()
	{
		new User("email", 0, 0);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid type!
	 */
	public function testUserThrowsExceptionForNonStringType()
	{
		new User("email", "password", 0);
	}
}
