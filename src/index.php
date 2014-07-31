<?php

require_once __DIR__ . '/../vendor/autoload.php';

$configuration = new \Tdd\Configuration();
$configuration->set(\Tdd\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
$configuration->set(\Tdd\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
$configuration->set(\Tdd\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'qwertzuiopasdfghjklyxcvbnm');
$configuration->set(\Tdd\Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => __DIR__ . '/../resource/user.db'));

(new \Tdd\Application(new \Tdd\Factory($configuration)))->run('/');
