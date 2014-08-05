<?php

namespace Tdd\Test;

use Tdd\PasswordValidator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testValidatePasswordLength()
    {
        $validator = new PasswordValidator(6, 64);
        $this->assertTrue($validator->isValid('password'));
        $this->assertFalse($validator->isValid('pas'));
    }

    public function testAcceptSpecialCharacters()
    {
        $validator = new PasswordValidator(6, 64);
        $this->assertTrue($validator->isValid('!!!!!!!!!!!!!!!!'));
    }
}