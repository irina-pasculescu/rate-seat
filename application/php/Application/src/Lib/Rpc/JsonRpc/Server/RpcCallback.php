<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/17/13
 * Time: 12:24 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;

/**
 * Class RpcCallback
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class RpcCallback
{

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
     * @param RpcFactory $rpcFactory
     * @param callable   $closure
     * @param array      $params
     */
    public function __construct(
        RpcFactory $rpcFactory,
        \Closure $closure,
        $params
    )
    {
        $this->setFactory( $rpcFactory );
        $this->setClosure( $closure );
        $this->setParams( $params );
    }

    /**
     * @var \Closure|null
     */
    protected $closure;
    /**
     * @var array
     */
    protected $params;

    /**
     * @param callable $closure
     *
     * @return $this
     */
    public function setClosure( \Closure $closure )
    {
        $this->closure = $closure;

        return $this;
    }

    /**
     * @return callable|null
     */
    public function getClosure()
    {
        return $this->closure;
    }

    /**
     * @return bool
     */
    public function hasClosure()
    {
        return $this->getClosure() instanceof \Closure;
    }

    /**
     * @param array $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setParams( $value )
    {
        if ( !is_array( $value ) ) {

            throw new \Exception( 'Invalid parameter "value" ! ' . __METHOD__ );
        }
        $this->params = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        $result = array();

        $value = $this->params;

        if ( is_array( $value ) ) {

            return $value;
        }

        return $result;
    }

}