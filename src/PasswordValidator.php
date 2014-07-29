<?php
/**
 * Created by PhpStorm.
 * User: frnc
 * Date: 2014.07.29.
 * Time: 18:04
 */

namespace Tdd;

class PasswordValidator implements IValidator {

    private $maxLength;
    private $minLength;

    function __construct($minLength, $maxLength)
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;
    }

    public function isValid($password)
    {
        $pattern = '/^.{' . $this->minLength . ',' . $this->maxLength . '}$/';
        return (bool)preg_match($pattern, $password);
    }
}
