<?php

namespace Tdd;

class EmailValidator implements IValidator
{
	public function isValid($email)
	{
		return (bool)preg_match('/^\w+\@\w+\.\w+$/', $email);
	}
}
