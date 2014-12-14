#!/usr/local/bin/php -d memory_limit=536870912 -f

<?php


ini_set( 'display_errors', true );
require __DIR__ . "/../../vendor/autoload.php";

use Application\Console\RateSeat\Dispatcher;

Dispatcher::getInstance()->run();

//./run.php  rate-seat:ios:lufthansa:get-flight-status  --apiToken=fk9qgddrt9uf4k7ug6w97xym --flightNumber="LH400" --date="2014-12-15"

//./run.php rate-seat:ios:lufthansa:get-offers-seat --apiToken=fk9qgddrt9uf4k7ug6w97xym --flightNumber="LH400" --date="2014-12-15" --origin="FRA" --destination="JFK" --cabinClass="Y"