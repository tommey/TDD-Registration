<?php

namespace Tdd\Test;

use Tdd\User;

class UserTest extends \PHPUnit_Framework_TestCase
{
	public function testUserCanStoreEmailAndPassword()
	{
		$email = "email@email.com";
		$password = "password";

		$user = new User($email, $password);

		$this->assertEquals($email, $user->getEmail());
		$this->assertEquals($password, $user->getPassword());
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid email!
	 */
	public function testUserThrowsExceptionForNonStringEmail()
	{
		new User(0, 0);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 * @expectedExceptionMessage Invalid password!
	 */
	public function testUserThrowsExceptionForNonStringPassword()
	{
		new User("email", 0);
	}
}
