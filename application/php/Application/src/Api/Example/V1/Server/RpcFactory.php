<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 11:37 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Api\Example\V1\Server;


use Application\Api\Base\Server\RpcFactory as AbstractFactory;
use Application\Lib\Rpc\JsonRpc\Server\RpcRouterEventHandlers;

/**
 * Class RpcFactory
 *
 * @package Application\Api\Example\V1\Server
 */
class RpcFactory extends AbstractFactory
{

    // =============== singleton ===========

    /**
     * @var self
     */
    private static $instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    // =========== implement abstracts =========

    /**
     * @return ApiManager
     */
    public function getApiManager()
    {
        if (!$this->apiManager) {
            $this->apiManager = new ApiManager($this);
        }

        return $this->apiManager;
    }


    /**
     * @return ApiManagerSettingsVo
     */
    public function createApiManagerSettingsVo()
    {
        return new ApiManagerSettingsVo();
    }


    // ======== overrides ===========

    /**
     * @return RpcRouterEventHandlers
     */
    public function createRouterEventHandlers()
    {
        return parent::createRouterEventHandlers();
    }

    public function createRouterCallback(\Closure $closure, $params)
    {
        return parent::createRouterCallback(
            $closure,
            $params
        );
    }

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