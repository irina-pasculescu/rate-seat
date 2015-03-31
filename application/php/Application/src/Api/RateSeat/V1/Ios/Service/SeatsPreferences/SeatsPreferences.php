<?php
/**
 * Created by IntelliJ IDEA.
 * User: irina
 * Date: 12/14/14
 * Time: 12:41 PM
 */

namespace Application\Api\RateSeat\V1\Ios\Service\SeatsPreferences;


use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\SeatsPreferences\Load\GetSeatsPreferencesRequestHandler;
use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\SeatsPreferences\Load\SeatsPreferencesRequestHandler;
use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\SeatsPreferences\Update\SetSeatsPreferencesRequestHandler;
use Application\Api\RateSeat\V1\Ios\Server\RpcService;

class OffersSeats extends RpcService
{

    /*
     {
        "method":"RateSeat.Ios.Lufthansa.SeatsPreferences.get",
        "params":[{

        }]
}
     */
    /**
     * @param array $request
     *
     * @return array
     */
    public function get( $request = array() )
    {
        $requestHandler = new GetSeatsPreferencesRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest( $request );
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function set( $request = array() )
    {
        $requestHandler = new SetSeatsPreferencesRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest( $request );
    }


}