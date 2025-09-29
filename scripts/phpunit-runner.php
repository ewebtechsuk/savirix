#!/usr/bin/env php
<?php

$autoloadPath = __DIR__ . '/../vendor/autoload.php';

if (!is_file($autoloadPath)) {
    fwrite(
        STDERR,
        "Composer autoload file not found. Please run `composer install` before executing the test suite." . PHP_EOL
    );
    exit(1);
}

require $autoloadPath;

use PHPUnit\TextUI\Application;

$application = new Application();

exit($application->run($_SERVER['argv'] ?? []));
