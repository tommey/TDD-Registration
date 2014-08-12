<?php

namespace Tdd\Test\Unit;

use Tdd\Module\FraudModule;

class FraudModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FraudModule */
    private $fraudModule;

    public function setUp()
    {
        $this->fraudModule = new FraudModule();
    }

    public function testShow()
    {
        $this->assertTrue(true);
    }
}
