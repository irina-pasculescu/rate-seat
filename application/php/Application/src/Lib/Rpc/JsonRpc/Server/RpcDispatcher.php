<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 12:07 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;

/**
 * Class DispatcherHttp
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
abstract class RpcDispatcher
{


    /**
     * @return $this
     */
    abstract public function run();

    /**
     * @var RpcFactory
     */
    protected $factory;

    /**
     * @param RpcFactory $factory
     *
     * @return $this
     */
    protected function setFactory(RpcFactory $factory)
    {
        $this->factory = $factory;

        return $this;
    }

    /**
     * @return RpcFactory
     */
    protected function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param RpcFactory $rpcFactory
     */
    public function __construct(RpcFactory $rpcFactory)
    {
        $this->setFactory($rpcFactory);
    }


}