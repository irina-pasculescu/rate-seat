<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:47 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Base\Server;

use Application\Context;
use Application\Lib\Rpc\JsonRpc\Server\RpcService as AbstractService;


/**
 * Class RpcService
 *
 * @package Application\Api\Base\Server
 */
class RpcService extends AbstractService
{
    /**
     * @return Context
     */
    protected function getApplicationContext()
    {
        return Context::getInstance();
    }

    /**
     * @throws \Exception
     * @return RpcFactory
     */
    protected function getFactory()
    {

        throw new \Exception( 'Implement! ' . __METHOD__ );
    }

    /**
     * override just for proper type hinting in ide
     *
     * @return Rpc
     */
    protected function getRpc()
    {
        return parent::getRpc();
    }


    /**
     * @return bool
     */
    public function ping()
    {
        return true;
    }


}