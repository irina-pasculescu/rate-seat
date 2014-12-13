<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:47 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Example\V1\Server;


use Application\Api\Base\Server\RpcService as BaseService;


/**
 * Class RpcService
 *
 * @package Application\Api\Example\V1\Server
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