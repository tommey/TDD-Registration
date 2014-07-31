<?php

namespace Tdd;

class UserTypeValidator implements IValidator
{
	public function isValid($userType)
	{
		return in_array($userType, array('local', 'facebook', 'google'));
	}
}
