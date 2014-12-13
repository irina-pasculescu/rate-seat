<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 2:26 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Base\Server;


use Application\Lib\Rpc\JsonRpc\Server\Rpc as BaseRpc;

/**
 * Class Rpc
 *
 * @package Application\Api\Base\Server
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


    /**
     * @var array
     */
    private $debug = array();

    /**
     * @param array $value
     *
     * @return $this
     */
    public function setDebug($value)
    {
        $this->debug = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getDebug()
    {
        return (array)$this->debug;
    }

    /**
     * @var RpcContext
     */
    protected $rpcContext;

    /**
     * @param RpcContext $value
     *
     * @return $this
     */
    public function setRpcContext(RpcContext $value)
    {
        $this->rpcContext = $value;

        return $this;
    }

    /**
     * @return RpcContext
     */
    public function getRpcContext()
    {
        return $this->rpcContext;
    }


}