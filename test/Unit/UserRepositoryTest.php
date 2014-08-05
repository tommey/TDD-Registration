<?php

namespace Tdd\Test;

use Tdd\SqliteStorage;
use Tdd\UserRepository;
use Tdd\User;

class UserRepositoryTest extends \PHPUnit_Framework_TestCase
{
	private $databaseFile;
	/** @var SqliteStorage */
	private $database;
	/** @var UserRepository */
	private $userRepository;

	public function __construct()
	{
		$this->databaseFile = __DIR__ . '/user.db';
	}

	public function setUp()
	{
		if (file_exists($this->databaseFile))
		{
			throw new \ErrorException('Database file (' . $this->databaseFile . ') exists before the test.. it should not be there!');
		}

		$this->database = new SqliteStorage(array('file' => $this->databaseFile));

		$this->database->exec(file_get_contents(__DIR__ . '/../../resource/user.db.sql'));

		$this->userRepository = new UserRepository($this->database);
	}

	public function tearDown()
	{
		unset($this->database, $this->userRepository);
		unlink($this->databaseFile);
	}

	public function testUserRepositoryCanStoreAndRetrieveAUser()
	{
		$email = 'new-user@email.com';
		$user  = new User($email, 'password', 'local');

		$this->assertTrue($this->userRepository->save($user));
		$this->assertEquals('exists', $this->database->query("SELECT 'exists' FROM user WHERE email = '$email'")->fetchColumn(0));
		$this->assertEquals($user, $this->userRepository->getByEmail($email));
	}

	public function testUserRepositoryReturnsNullForNonExistingUserByEmail()
	{
		$email = 'non-existing-email@address.com';

		$this->assertSame(null, $this->userRepository->getByEmail($email));
	}

	public function testUserRepositoryCanRetrieveUserByCredentials()
	{
		$email    = 'new-user@email.com';
		$password = 'password';
		$user     = new User($email, $password, 'local');

		$this->assertTrue($this->userRepository->save($user));
		$this->assertEquals('exists', $this->database->query("SELECT 'exists' FROM user WHERE email = '$email'")->fetchColumn(0));
		$this->assertEquals($user, $this->userRepository->getByCredentials($email, $password));
	}

	public function testUserRepositoryCanNotRetrieveUserByInvalidCredentials()
	{
		$email    = 'new-user@email.com';
		$password = 'password';
		$user     = new User($email, $password, 'local');

		$this->assertTrue($this->userRepository->save($user));
		$this->assertEquals('exists', $this->database->query("SELECT 'exists' FROM user WHERE email = '$email'")->fetchColumn(0));
		$this->assertEquals(null, $this->userRepository->getByCredentials($email, 'pass'));
	}
}
