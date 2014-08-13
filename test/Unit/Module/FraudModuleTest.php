<?php

namespace Tdd\Test\Unit;

use Tdd\Cache\ICacheStorage;
use Tdd\Entity\Attempt;
use Tdd\Module\FraudModule;

class FraudModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FraudModule */
    private $fraudModule;

    public function setUp()
    {
		/** @var ICacheStorage|\PHPUnit_Framework_MockObject_MockObject $storage */
        $storage = $this->getMockBuilder('\\Tdd\\Cache\\ICacheStorage')->getMock();

        $this->fraudModule = new FraudModule($storage);
    }

    public function testIpAttemptCounterIncreasedAfterFirstFailedAttempt()
    {
        $attempt = new Attempt('123.123.123.123', 'Joe');

        $this->fraudModule->storeFailedAttempt($attempt);
        $this->assertEquals(1, $this->fraudModule->getIpAttemptCounter($attempt));
    }

    public function testFraudDetectedAfterThreeFailedAttemptFromTheSameIp()
    {
        $attempt = new Attempt('123.123.123.123', 'Joe');

        for ($i=0; $i<3; $i++) {
            $this->fraudModule->storeFailedAttempt($attempt);
        }

        $this->assertEquals(3, $this->fraudModule->getIpAttemptCounter($attempt));
        $this->assertTrue($this->fraudModule->isFraudDetected());
    }
}
