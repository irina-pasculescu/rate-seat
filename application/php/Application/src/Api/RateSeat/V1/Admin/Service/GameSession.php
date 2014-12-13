<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:22 PM
 */

namespace Application\Api\RateSeat\V1\Admin\Service;



use
    Application\Api\RateSeat\V1\Admin\RequestHandler\GameSession\Create\GameSessionCreateRequestHandler;
use Application\Api\RateSeat\V1\Admin\Server\RpcService;

class GameSession extends RpcService
{


    /**
     * @param array $request
     * @return array
     */
    public function create($request = array())
    {
        $requestHandler = new GameSessionCreateRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest($request);
    }


}