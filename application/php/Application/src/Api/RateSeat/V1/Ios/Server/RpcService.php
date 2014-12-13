<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:47 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\RateSeat\V1\Ios\Server;


use Application\Api\Base\Server\RpcService as BaseService;


/**
 * Class RpcService
 * @package Application\Api\RateSeat\V1\Ios\Server
 */
class RpcService extends BaseService
{
    /**
     * @return RpcFactory
     */
    protected function getFactory()
    {
        return RpcFactory::getInstance();
    }

    /**
     * @return Rpc
     */
    protected function getRpc()
    {
        return parent::getRpc();
    }


}