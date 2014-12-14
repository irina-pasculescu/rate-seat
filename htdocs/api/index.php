<?php
/**
 * Created by IntelliJ IDEA.
 * User: irina
 * Date: 12/14/14
 * Time: 11:07 AM
 */

require_once __DIR__ . "/../../vendor/autoload.php";

use Application\Api\RateSeat\V1\Ios\Server\RpcFactory;
use Application\Bootstrap;

$bootstrap = Bootstrap::getInstance();
$bootstrap->init( $bootstrap::MODE_HTTP );


RpcFactory::getInstance()
          ->getDispatcherHttp()
          ->run();