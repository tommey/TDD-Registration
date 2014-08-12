<?php

namespace Tdd\Test\Unit\Entity;

use Tdd\Entity\Attempt;

class AttemptTest extends \PHPUnit_Framework_TestCase
{
    public function testAttemptCanStoreIpAndUsername()
    {
        $ip       = '192.164.123.1';
        $username = 'Margit';
        $attempt  = new Attempt($ip, $username);

        $this->assertEquals($ip, $attempt->getIp());
        $this->assertEquals($username, $attempt->getUsername());
    }
}
