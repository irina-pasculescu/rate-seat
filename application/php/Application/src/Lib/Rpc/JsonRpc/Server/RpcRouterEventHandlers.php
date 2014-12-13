<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/17/13
 * Time: 8:45 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;

/**
 * Class RpcRouterEventHandlers
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class RpcRouterEventHandlers
{


    /**
     * @var RpcFactory
     */
    private $factory;

    /**
     * @param RpcFactory $factory
     *
     * @return $this
     */
    private function setFactory(RpcFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return RpcFactory
     */
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param RpcFactory $factory
     */
    public function __construct(RpcFactory $factory)
    {
        $this->setFactory($factory);
    }

    // =========== initRpc ============================

    /**
     * @var RpcCallback
     */
    protected $onBeforeInitRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnBeforeInitRpc(RpcCallback $value)
    {
        $this->onBeforeInitRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnBeforeInitRpc()
    {
        $this->onBeforeInitRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback
     */
    public function getOnBeforeInitRpc()
    {
        return $this->onBeforeInitRpc;
    }

    /**
     * @return bool
     */
    public function hasOnBeforeInitRpc()
    {
        return $this->onBeforeInitRpc !== null;
    }


    /**
     * @var RpcCallback|null
     */
    protected $onAfterInitRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnAfterInitRpc(RpcCallback $value)
    {
        $this->onAfterInitRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnAfterInitRpc()
    {
        $this->onAfterInitRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback|null
     */
    public function getOnAfterInitRpc()
    {
        return $this->onAfterInitRpc;
    }

    /**
     * @return bool
     */
    public function hasOnAfterInitRpc()
    {
        return $this->onAfterInitRpc !== null;
    }


    // =========== routeRpc ============================

    /**
     * @var RpcCallback
     */
    protected $onBeforeRouteRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnBeforeRouteRpc(RpcCallback $value)
    {
        $this->onBeforeRouteRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnBeforeRouteRpc()
    {
        $this->onBeforeRouteRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback
     */
    public function getOnBeforeRouteRpc()
    {
        return $this->onBeforeRouteRpc;
    }

    /**
     * @return bool
     */
    public function hasOnBeforeRouteRpc()
    {
        return $this->onBeforeRouteRpc !== null;
    }


    /**
     * @var RpcCallback|null
     */
    protected $onAfterRouteRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnAfterRouteRpc(RpcCallback $value)
    {
        $this->onAfterRouteRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnAfterRouteRpc()
    {
        $this->onAfterRouteRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback|null
     */
    public function getOnAfterRouteRpc()
    {
        return $this->onAfterRouteRpc;
    }

    /**
     * @return bool
     */
    public function hasOnAfterRouteRpc()
    {
        return $this->onAfterRouteRpc !== null;
    }


    // =========== invokeRpc ============================

    /**
     * @var RpcCallback
     */
    protected $onBeforeInvokeRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnBeforeInvokeRpc(RpcCallback $value)
    {
        $this->onBeforeInvokeRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnBeforeInvokeRpc()
    {
        $this->onBeforeInvokeRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback
     */
    public function getOnBeforeInvokeRpc()
    {
        return $this->onBeforeInvokeRpc;
    }

    /**
     * @return bool
     */
    public function hasOnBeforeInvokeRpc()
    {
        return $this->onBeforeInvokeRpc !== null;
    }


    /**
     * @var RpcCallback|null
     */
    protected $onAfterInvokeRpc;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnAfterInvokeRpc(RpcCallback $value)
    {
        $this->onAfterInvokeRpc = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnAfterInvokeRpc()
    {
        $this->onAfterInvokeRpc = null;

        return $this;
    }

    /**
     * @return RpcCallback|null
     */
    public function getOnAfterInvokeRpc()
    {
        return $this->onAfterInvokeRpc;
    }

    /**
     * @return bool
     */
    public function hasOnAfterInvokeRpc()
    {
        return $this->onAfterInvokeRpc !== null;
    }


    // =========== createRpcResponseData ============================

    /**
     * @var RpcCallback
     */
    protected $onBeforeCreateRpcResponseData;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnBeforeCreateRpcResponseData(RpcCallback $value)
    {
        $this->onBeforeCreateRpcResponseData = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnBeforeCreateRpcResponseData()
    {
        $this->onBeforeCreateRpcResponseData = null;

        return $this;
    }

    /**
     * @return RpcCallback
     */
    public function getOnBeforeCreateRpcResponseData()
    {
        return $this->onBeforeCreateRpcResponseData;
    }

    /**
     * @return bool
     */
    public function hasOnBeforeCreateRpcResponseData()
    {
        return $this->onBeforeCreateRpcResponseData !== null;
    }


    /**
     * @var RpcCallback|null
     */
    protected $onAfterCreateRpcResponseData;

    /**
     * @param RpcCallback $value
     *
     * @return $this
     */
    public function setOnAfterCreateRpcResponseData(RpcCallback $value)
    {
        $this->onAfterCreateRpcResponseData = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetOnAfterCreateRpcResponseData()
    {
        $this->onAfterCreateRpcResponseData = null;

        return $this;
    }

    /**
     * @return RpcCallback|null
     */
    public function getOnAfterCreateRpcResponseData()
    {
        return $this->onAfterCreateRpcResponseData;
    }

    /**
     * @return bool
     */
    public function hasOnAfterCreateRpcResponseData()
    {
        return $this->onAfterCreateRpcResponseData !== null;
    }
}