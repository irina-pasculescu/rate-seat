<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 5:42 PM
 */

namespace Application\Api\RateSeat\V1\Admin\Service;


use
    Application\Api\RateSeat\V1\Admin\RequestHandler\User\Load\UserLoadRequestHandler;
use Application\Api\RateSeat\V1\Admin\Server\RpcService;

class User extends RpcService
{

    /**
     * @param array $request
     * @return array
     */
    public function show($request = array())
    {
        $requestHandler = new UserLoadRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest($request);
    }
}