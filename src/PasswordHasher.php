<?php

namespace Tdd;

class PasswordHasher
{
	public function hash($password)
	{
		return sha1($password);
	}
}
