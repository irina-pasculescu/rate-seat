<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 5:43 PM
 */

namespace Application\Api\RateSeat\V1\Admin\Service\User;


use
    Application\Api\RateSeat\V1\Admin\RequestHandler\User\Wallet\Increase\UserWalletIncreaseRequestHandler;
use Application\Api\RateSeat\V1\Admin\Server\RpcService;

class Wallet extends RpcService
{
    /**
     * @param array $request
     * @return array
     */
    public function increase($request = array())
    {
        $requestHandler = new UserWalletIncreaseRequestHandler(
            $this->getRpc()->getRpcContext()
        );

        return $requestHandler->handleRequest($request);
    }
} 