<?php
/**
 * Created by IntelliJ IDEA.
 * User: irina
 * Date: 12/14/14
 * Time: 12:41 PM
 */

namespace Application\Api\RateSeat\V1\Ios\Service\Lufthansa;


use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\OffersSeatMaps\Load\OffersSeatMapsLoadRequestHandler;
use Application\Api\RateSeat\V1\Ios\Server\RpcService;

class OffersSeats extends RpcService
{

    /*
     {
        "method":"RateSeat.Ios.Lufthansa.OffersSeats.get",
        "params":[{
            "flightNumber":"LH400",
            "date":"2014-12-15",
            "origin":"FRA",
            "destination":"JFK",
            "cabinClass":"Y"
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
        $requestHandler = new OffersSeatMapsLoadRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest( $request );
    }


}