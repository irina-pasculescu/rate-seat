#!/usr/local/bin/php -d memory_limit=536870912 -f

<?php


ini_set('display_errors', true);
require __DIR__ . "/../../vendor/autoload.php";

use Application\Console\RateSeat\Dispatcher;

Dispatcher::getInstance()->run();