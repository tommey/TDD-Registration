<?php

namespace Tdd;

class PasswordValidator implements IValidator {

	private $minLength;
	private $maxLength;

    public function __construct($minLength, $maxLength)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function isValid($password)
    {
        $length = strlen($password);

        return $this->minLength <= $length && $length <= $this->maxLength;
    }
}
