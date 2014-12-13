<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 11:39 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;


/**
 * Class RpcFactory
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
abstract class RpcFactory
{

    /**
     * @throws \Exception
     */
    public static function getInstance()
    {
        throw new \Exception(
            'Implement ' . __METHOD__ . ' for ' . get_called_class()
        );
    }


    /**
     * @return RpcDispatcher
     */
    abstract function getDispatcherHttp();


    /**
     * @var RpcRouter
     */
    protected $router;

    /**
     * @return RpcRouter
     */
    public function getRouter()
    {
        if (!$this->router) {
            $this->router = new RpcRouter($this);
        }

        return $this->router;
    }


    /**
     * @return Rpc
     */
    public function createRpc()
    {
        return new Rpc($this);
    }

    /**
     * @return RpcRequestVo
     */
    public function createRpcRequestVo()
    {
        return new RpcRequestVo();
    }

    /**
     * @return RpcResponseVo
     */
    public function createRpcResponseVo()
    {
        return new RpcResponseVo();
    }


    /**
     * @return RpcRouterEventHandlers
     */
    public function createRouterEventHandlers()
    {
        return new RpcRouterEventHandlers($this);
    }

    /**
     * @param callable $closure
     * @param array $params
     *
     * @return RpcCallback
     */
    public function createRouterCallback(\Closure $closure, $params)
    {
        return new RpcCallback($this, $closure, $params);
    }
}