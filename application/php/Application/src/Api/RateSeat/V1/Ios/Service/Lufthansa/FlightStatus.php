<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/9/14
 * Time: 9:57 AM
 */

namespace Application\Api\RateSeat\V1\Ios\Service\Lufthansa;

use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Load\FlightStatusLoadRequestHandler;
use Application\Api\RateSeat\V1\Ios\Server\RpcService;

class FlightStatus extends RpcService
{


    /**
     * @param array $request
     * @return array
     */
    public function get($request = array())
    {
        $requestHandler = new FlightStatusLoadRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest($request);
    }


}