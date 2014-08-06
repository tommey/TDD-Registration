<?php

namespace Tdd\Validator;

/**
 * @codeCoverageIgnore
 */
interface IValidator
{
	/**
	 * @param mixed $valueToValidate
	 *
	 * @return bool
	 */
	public function isValid($valueToValidate);
}
