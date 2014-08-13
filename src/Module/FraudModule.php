<?php

namespace Tdd\Module;

use Tdd\Cache\ICacheStorage;
use Tdd\Entity\Attempt;

class FraudModule
{
    private $storage;

    private $ipAttemptCounter;

    public function __construct(ICacheStorage $storage)
    {
        $this->storage = $storage;
    }

    public function storeFailedAttempt(Attempt $attempt)
    {
		$ip = $attempt->getIp();
        $this->ipAttemptCounter[$ip] =
			isset($this->ipAttemptCounter[$ip])
            ? ++$this->ipAttemptCounter[$ip]
            : 1;
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
