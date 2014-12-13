<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/9/14
 * Time: 9:57 AM
 */

namespace Application\Api\RateSeat\V1\Game\Service\Player;

use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Load\FlightStatusLoadRequestHandler;
use Application\Api\RateSeat\V1\Ios\Server\RpcService;

class FlightStatus extends RpcService
{


    // Player.Session.load

    /*

        The call get is used to request data for the current game session,
        including game and user data.
        Please note that game settings can be changed by subsequent requests
        and events like leveling up for example.

        Payload:
            {} - No payload needed so please provide an empty JSON array here.

        Response

            - user: User {"_id":"53fc9eb31b4d5eef118b4569 ","username":"john_doe”, ....}
            - game: {"settings":{"bets":[50, 100, 250]}}

    */

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