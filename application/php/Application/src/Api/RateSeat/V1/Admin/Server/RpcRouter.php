<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 5/28/13
 * Time: 11:27 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\RateSeat\V1\Admin\Server;

use Application\Api\Base\Server\RpcRouter as AbstractRouter;


/**
 * Class RpcRouter
 *
 * @package Application\Api\RateSeat\V1\Admin\Server
 */
class RpcRouter
    extends AbstractRouter
{

    /**
     * override just for proper type hinting in ide
     *
     * @return RpcFactory
     */
    public function getFactory()
    {
        return parent::getFactory();
    }

    /**
     * override just for proper type hinting in ide
     *
     * @return Rpc
     */
    public function getRpc()
    {
        return parent::getRpc();
    }


}