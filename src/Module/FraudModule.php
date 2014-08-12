<?php

namespace Tdd\Module;

use Tdd\Cache\CacheStorage;
use Tdd\Entity\Attempt;

class FraudModule
{
    private $storage;

    private $ipAttemptCounter;

    public function __construct(CacheStorage $storage)
    {
        $this->storage = $storage;
    }

    public function storeFailedAttempt(Attempt $attempt)
    {
        $this->ipAttemptCounter[$attempt->getIp()] = isset($this->ipAttemptCounter[$attempt->getIp()])
            ? ++$this->ipAttemptCounter[$attempt->getIp()]
            : 1
        ;
    }

    public function getIpAttemptCounter(Attempt $attempt)
    {
        return $this->ipAttemptCounter[$attempt->getIp()];
    }

    public function isFraudDetected()
    {
        return true;
    }
}
