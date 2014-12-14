<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 12:32 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;


/**
 * Class Service
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
abstract class RpcService
{

    /**
     * @var Rpc
     */
    protected $rpc;

    /**
     * @param $rpc
     *
     * @return $this
     */
    protected function setRpc( $rpc )
    {
        $this->rpc = $rpc;

        return $this;
    }

    /**
     * @return Rpc
     */
    protected function getRpc()
    {
        return $this->rpc;
    }

    /**
     * @var RpcFactory
     */
    protected $factory;

    /**
     * @param RpcFactory $factory
     *
     * @return $this
     */
    protected function setFactory( RpcFactory $factory )
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
     * @param RpcFactory $factory
     * @param Rpc        $rpc
     */
    public function __construct( RpcFactory $factory, Rpc $rpc )
    {
        $this->setFactory( $factory );
        $this->setRpc( $rpc );
    }

}