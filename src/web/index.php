<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$configuration = new \Tdd\Common\Configuration();
$configuration->set(\Tdd\Common\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MINIMUM_LENGTH, 6);
$configuration->set(\Tdd\Common\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_MAXIMUM_LENGTH, 64);
$configuration->set(\Tdd\Common\Key::CONFIGURATION_VALIDATOR_USER_PASSWORD_CHARACTER_SET, 'qwertzuiopasdfghjklyxcvbnm');
$configuration->set(\Tdd\Common\Key::CONFIGURATION_STORAGE_USER_DATABASE_CONFIGURATION, array('file' => __DIR__ . '/../resource/user.db'));

(new \Tdd\Common\Application(new \Tdd\Common\Factory($configuration)))->run('/');
