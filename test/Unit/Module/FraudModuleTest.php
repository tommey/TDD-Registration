<?php

namespace Tdd\Test\Unit;

use Tdd\Entity\Attempt;
use Tdd\Module\FraudModule;

class FraudModuleTest extends \PHPUnit_Framework_TestCase
{
    /** @var  FraudModule */
    private $fraudModule;

    public function setUp()
    {
        $storage = $this->getMockBuilder('\\Tdd\\Cache\\CacheStorage')->getMock();

        $this->fraudModule = new FraudModule($storage);
    }

    public function testIpAttemptCounterIncreasedAfterFirstFailedAttempt()
    {
        $attempt = new Attempt('123.123.123', 'Gizi');

        $this->fraudModule->storeFailedAttempt($attempt);
        $this->assertEquals(1, $this->fraudModule->getIpAttemptCounter($attempt));
    }

    public function testFraudDetectedAfterThreeFailedAttemptFromTheSameIp()
    {
        $attempt = new Attempt('123.123.123', 'Gizi');

        for ($i=0; $i<3; $i++) {
            $this->fraudModule->storeFailedAttempt($attempt);
        }

        $this->assertEquals(3, $this->fraudModule->getIpAttemptCounter($attempt));
        $this->assertTrue($this->fraudModule->isFraudDetected());
    }
}
