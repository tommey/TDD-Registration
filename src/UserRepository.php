<?php

namespace Tdd;

class UserRepository
{
	/** @var PersistentStorage */
	private $persistentStorage;

	public function __construct(PersistentStorage $persistentStorage)
	{
		$this->persistentStorage = $persistentStorage;
	}

	public function save(User $user)
	{
		$stmt = $this->persistentStorage->prepare('INSERT OR IGNORE INTO user (email, password, type) VALUES (?, ?, ?)');

		return $stmt->execute(array($user->getEmail(), $user->getPassword(), $user->getType()));
	}

	public function getByEmail($email)
	{
		$stmt = $this->persistentStorage->prepare('SELECT * FROM user WHERE email = ? LIMIT 1');
		if (!$stmt->execute(array($email)))
		{
			return null;
		}

		$row = $stmt->fetch();
		if (!is_array($row))
		{
			return null;
		}

		return new User($row['email'], $row['password'], $row['type']);
	}

	public function getByCredentials($email, $password)
	{
		$stmt = $this->persistentStorage->prepare('SELECT * FROM user WHERE email = ? AND password = ? LIMIT 1');
		if (!$stmt->execute(array($email, $password)))
		{
			return null;
		}

		$row = $stmt->fetch();
		if (!is_array($row))
		{
			return null;
		}

		return new User($row['email'], $row['password'], $row['type']);
	}
}
