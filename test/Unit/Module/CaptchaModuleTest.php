<?php

namespace Tdd\Test\Unit;

use Tdd\Module\CaptchaModule;

class CaptchaModuleTest extends \PHPUnit_Framework_TestCase
{

    /** @var  CaptchaModule */
    private $captchaModule;

    public function setUp()
    {
        $this->captchaModule = new CaptchaModule();
    }

    public function testLoad()
    {
        $this->assertTrue(true);
    }
} 