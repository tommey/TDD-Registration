<?php

namespace Tdd;

class UserTypeValidator implements IValidator
{
	/**
	 * @param string $userType
	 *
	 * @return bool
	 */
	public function isValid($userType)
	{
		return is_string($userType) && in_array($userType, array('local', 'facebook', 'google'));
	}
}
