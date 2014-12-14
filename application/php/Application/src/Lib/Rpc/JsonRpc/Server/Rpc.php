<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 9/16/13
 * Time: 11:55 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;


/**
 * Class Rpc
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class Rpc
{
    const HTTP_STATUS_HEADER_500                = 'HTTP/1.0 500 Internal Server Error';
    const HTTP_STATUS_HEADER_420_METHOD_FAILURE = '420 Method Failure';

    /**
     * @var RpcFactory
     */
    private $factory;

    /**
     * @param RpcFactory $factory
     *
     * @return $this
     */
    private function setFactory( RpcFactory $factory )
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
     *
     */
    public function __construct( RpcFactory $factory )
    {
        $this->setFactory( $factory );
    }


    /**
     * @var RpcRequestVo
     */
    private $rpcRequestVo;

    /**
     * @param RpcRequestVo $requestVo
     *
     * @return $this
     *
     */
    public function setRpcRequestVo( RpcRequestVo $requestVo )
    {
        $this->rpcRequestVo = $requestVo;

        return $this;
    }

    /**
     * @return RpcRequestVo
     * @throws \Exception
     */
    public function getRpcRequestVo()
    {
        $value = $this->rpcRequestVo;
        if ( !$value ) {

            throw new \Exception( 'rpc.rpcRequestVo not set! ' . __METHOD__ );
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function hasRpcRequestVo()
    {
        return $this->rpcRequestVo instanceof RpcRequestVo;
    }


    /**
     * @var RpcResponseVo
     */
    private $rpcResponseVo;

    /**
     * @param RpcResponseVo $requestVo
     *
     * @return $this
     *
     */
    public function setRpcResponseVo( RpcResponseVo $requestVo )
    {
        $this->rpcResponseVo = $requestVo;

        return $this;
    }

    /**
     * @return RpcResponseVo
     * @throws \Exception
     */
    public function getRpcResponseVo()
    {
        $value = $this->rpcResponseVo;
        if ( !$value ) {

            throw new \Exception( 'rpc.rpcResponseVo not set! ' . __METHOD__ );
        }

        return $value;
    }

    /**
     * @return bool
     */
    public function hasRpcResponseVo()
    {
        return $this->rpcResponseVo instanceof RpcResponseVo;
    }


    /**
     * @var array
     */
    private $serviceMethodArgs;


    /**
     * @param array $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setServiceMethodArgs( $value )
    {
        if ( !is_array( $value ) ) {

            throw new \Exception( 'Invalid parameter "value" ! ' . __METHOD__ );
        }

        $this->serviceMethodArgs = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getServiceMethodArgs()
    {
        $result = array();
        $value  = $this->serviceMethodArgs;
        if ( !is_array( $value ) ) {

            return $result;
        }

        return $this->serviceMethodArgs;
    }

    /**
     * @var mixed
     */
    protected $serviceMethodResult;

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setServiceMethodResult( $value )
    {
        $this->serviceMethodResult = $value;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceMethodResult()
    {
        return $this->serviceMethodResult;
    }


    /**
     * @var \Exception|null
     */
    protected $exception;

    /**
     * @param mixed $value
     *
     * @return $this
     */
    public function setException( \Exception $value )
    {
        $this->exception = $value;

        return $this;
    }

    /**
     * @return \Exception|null
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @return bool
     */
    public function hasException()
    {
        return $this->exception instanceof \Exception;
    }

    /**
     * @var RpcService|null
     */
    private $serviceClassInstance;

    /**
     * @param RpcService $value
     *
     * @return $this
     */
    public function setServiceClassInstance( RpcService $value )
    {
        $this->serviceClassInstance = $value;

        return $this;
    }

    /**
     * @return RpcService|null
     */
    public function getServiceClassInstance()
    {
        return $this->serviceClassInstance;
    }

    /**
     * @var string
     */
    private $serviceMethodName = '';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setServiceMethodName( $value )
    {
        $this->serviceMethodName = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getServiceMethodName()
    {
        return (string)$this->serviceMethodName;
    }


    protected $isDebugEnabled = false;

    /**
     * @param boolean $isDebugEnabled
     */
    public function setIsDebugEnabled( $isDebugEnabled )
    {
        $this->isDebugEnabled = $isDebugEnabled;
    }

    /**
     * @return boolean
     */
    public function getIsDebugEnabled()
    {
        return $this->isDebugEnabled === true;
    }


    /**
     * @var string
     */
    protected $responseHttpStatusHeader = '';

    /**
     * @param string $responseHttpStatusHeader
     *
     * @return $this
     */
    public function setResponseHttpStatusHeader( $responseHttpStatusHeader )
    {
        $this->responseHttpStatusHeader = $responseHttpStatusHeader;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetResponseHttpStatusHeader()
    {
        $this->responseHttpStatusHeader = '';

        return $this;
    }

    /**
     * @return string
     */
    public function getResponseHttpStatusHeader()
    {
        return (string)$this->responseHttpStatusHeader;
    }

    /**
     * @return bool
     */
    public function hasResponseHttpStatusHeader()
    {
        $header = $this->getResponseHttpStatusHeader();

        return is_string( $header ) && ( !empty( $header ) );
    }

    /**
     * @var array
     */
    protected $responseData;

    /**
     * @param array $value
     *
     * @return $this
     * @throws \Exception
     */
    public function setResponseData( $value )
    {
        if ( !is_array( $value ) ) {

            throw new \Exception( 'Invalid parameter "value" ! ' . __METHOD__ );
        }

        $this->responseData = $value;

        return $this;
    }

    /**
     * @return array
     */
    public function getResponseData()
    {
        $result = array();
        $value  = $this->responseData;

        if ( is_array( $value ) ) {

            return $value;
        }

        return $result;
    }


    /**
     * @var string
     */
    protected $routeName = '';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setRouteName( $value )
    {
        $this->routeName = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        return (string)$this->routeName;
    }

}