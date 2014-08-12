<?php

$class = new ReflectionClass('Memcache');
$methods = $class->getMethods();
var_dump($methods);
