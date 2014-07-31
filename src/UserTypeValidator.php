<?php

namespace Tdd;

class UserTypeValidator implements IValidator
{
	public function isValid($userType)
	{
		return is_string($userType) && in_array($userType, array('local', 'facebook', 'google'));
	}
}
