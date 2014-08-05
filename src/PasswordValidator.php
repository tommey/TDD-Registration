<?php

namespace Tdd;

class PasswordValidator implements IValidator
{
	/** @var int */
	private $minLength;
	/** @var int */
	private $maxLength;

	/**
	 * @param int $minLength
	 * @param int $maxLength
	 */
	public function __construct($minLength, $maxLength)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

	/**
	 * @param string $password
	 *
	 * @return bool
	 */
	public function isValid($password)
    {
        $length = strlen($password);

        return $this->minLength <= $length && $length <= $this->maxLength;
    }
}
