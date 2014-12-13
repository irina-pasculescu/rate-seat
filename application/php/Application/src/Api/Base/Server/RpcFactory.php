<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 11:37 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Base\Server;

use Application\Lib\Rpc\JsonRpc\Server\RpcFactory as AbstractFactory;


/**
 * Class RpcFactory
 *
 * @package Application\Api\Base\Server
 */
abstract class RpcFactory extends AbstractFactory
{


    /**
     * @throws \Exception
     * @return self
     */
    public static function getInstance()
    {
        throw new \Exception('Implement! ' . __METHOD__);


    }


    /**
     * @var RpcDispatcherHttp
     */
    protected $dispatcherHttp;


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
     * @return RpcDispatcherHttp
     */
    public function getDispatcherHttp()
    {
        if (!$this->dispatcherHttp) {
            $this->dispatcherHttp = new RpcDispatcherHttp($this);
        }

        return $this->dispatcherHttp;
    }


    /**
     * @var ApiManager
     */
    protected $apiManager;

    /**
     * @return ApiManager
     */
    abstract public function getApiManager();

    /**
     * @return ApiManagerSettingsVo
     */
    abstract public function createApiManagerSettingsVo();


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


}