<?php

namespace Tdd\Validator;

class NonEmptyStringArgumentValidator implements IValidator
{
	/**
	 * @param string $string
	 *
	 * @return bool
	 */
	public function isValid($string)
	{
		return is_string($string) && !empty($string);
	}
}
