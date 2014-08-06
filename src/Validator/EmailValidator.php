<?php

namespace Tdd\Validator;

class EmailValidator implements IValidator
{
	/**
	 * @param string $email
	 *
	 * @return bool
	 */
	public function isValid($email)
	{
		return (bool)preg_match('/^\w+\@\w+\.\w+$/', $email);
	}
}
