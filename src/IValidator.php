<?php

namespace Tdd;

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
