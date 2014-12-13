<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:26 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Example\V1\Server;

use Application\Api\Base\Server\Rpc as BaseRpc;

/**
 * Class Rpc
 *
 * @package Application\Api\Example\V1\Server
 */
class Rpc extends BaseRpc
{

    /**
     * override just for proper type hinting in ide
     *
     * @return RpcRequestVo
     */
    public function getRpcRequestVo()
    {
        return parent::getRpcRequestVo();
    }

    /**
     * override just for proper type hinting in ide
     *
     * @return RpcResponseVo
     */
    public function getRpcResponseVo()
    {
        return parent::getRpcResponseVo();
    }

}