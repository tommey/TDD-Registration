<?php

namespace Tdd\Entity;

class Attempt
{
    private $ip;
    private $username;

    public function __construct($ip, $username)
    {
        $this->ip       = $ip;
        $this->username = $username;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getUsername()
    {
        return $this->username;
    }
}