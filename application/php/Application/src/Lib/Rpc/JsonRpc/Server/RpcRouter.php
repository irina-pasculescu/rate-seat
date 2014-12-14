<?php
/**
 * Created by JetBrains PhpStorm.
 * User: irina
 * Date: 4/22/13
 * Time: 11:27 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\Lib\Rpc\JsonRpc\Server;

use Application\Lib\Rpc\JsonRpc\Utils\JsonEncoderUtil;
use Application\Utils\ArrayAssocUtil;
use Application\Utils\ArrayListUtil;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;

/**
 * Class Router
 *
 * @package Application\Lib\Rpc\JsonRpc\Server
 */
class RpcRouter
{
    const HTTP_STATUS_HEADER_500 = Rpc::HTTP_STATUS_HEADER_500;

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
    public function getFactory()
    {
        return $this->factory;
    }

    /**
     * @param RpcFactory $rpcFactory
     */
    public function __construct( RpcFactory $rpcFactory )
    {
        $this->setFactory( $rpcFactory );
    }

    /**
     * @var array
     */
    protected $routes = array();


    /**
     * @var null|\Exception
     */
    protected $exception = null;

    /**
     * @param \Exception|null $exception
     */
    public function setException( \Exception $exception )
    {
        $this->exception = $exception;
    }

    /**
     *
     */
    public function unsetException()
    {
        $this->exception = null;
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
        return ( $this->exception instanceof \Exception );
    }

    /**
     * @param $value
     * @param $assoc
     * @param $delegateExceptions
     *
     * @return mixed|null
     */
    public function decodeJson( $value, $assoc, $delegateExceptions )
    {
        return JsonEncoderUtil::decode( $value, $assoc, $delegateExceptions );
    }


    /**
     * @var string
     */
    protected $responseText = '';

    /**
     * @param string $text
     */
    public function setResponseText( $text )
    {
        $this->responseText = $text;
    }

    /**
     *
     */
    public function unsetResponseText()
    {
        $this->responseText = '';
    }

    /**
     * @return string
     */
    public function getResponseText()
    {
        return (string)$this->responseText;
    }


    /**
     * @var null|array
     */
    protected $requestData = null;

    /**
     * @param array|null|mixed $requestData
     *
     * @return $this
     */
    public function setRequestData( $requestData )
    {
        $this->requestData = $requestData;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetRequestData()
    {
        $this->requestData = null;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRequestData()
    {
        return $this->requestData;
    }

    /**
     * @var null|array
     */
    protected $responseData = null;

    /**
     * @param array $data
     *
     * @return $this
     */
    public function setResponseData( array $data )
    {
        $this->responseData = $data;

        return $this;
    }

    /**
     * @return $this
     */
    public function unsetResponseData()
    {
        $this->responseData = null;

        return $this;
    }

    /**
     * @return array|null|mixed
     */
    public function getResponseData()
    {
        return $this->responseData;
    }

    /**
     * @var string
     */
    protected $responseHttpStatusHeader = '';

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setResponseHttpStatusHeader( $value )
    {
        $this->responseHttpStatusHeader = $value;

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
     * @var Rpc
     */
    protected $rpc = null;

    /**
     * @param Rpc $rpc
     */
    public function setRpc( Rpc $rpc )
    {
        $this->rpc = $rpc;
    }

    /**
     * @return Rpc
     */
    public function getRpc()
    {
        return $this->rpc;
    }

    /**
     * @return $this
     */
    public function unsetRpc()
    {
        $this->rpc = null;

        return $this;
    }


    /**
     * @param string $rpcMethod
     * @param string $serviceClass
     * @param string $serviceMethod
     *
     * @return self
     */
    public function addRoute( $rpcMethod, $serviceClass, $serviceMethod )
    {
        $this->routes[ $rpcMethod ] = array(
            'rpcMethod'     => $rpcMethod,
            'serviceClass'  => $serviceClass,
            'serviceMethod' => $serviceMethod,
        );

        return $this;
    }

    /**
     * @param array $routes
     *
     * @return $this
     */
    public function setRoutes( array $routes )
    {
        $this->routes = $routes;

        return $this;
    }

    /**
     * @return $this
     */
    public function route()
    {
        $this->unsetRpc();
        $this->unsetException();
        $this->unsetResponseData();
        $this->unsetResponseHttpStatusHeader();

        $rpcResponseData  = null;
        $isRequestBatched = false;
        try {
            $requestData = $this->getRequestData();
            $isBatched   = ArrayListUtil::isArrayList( $requestData )
                           && ( !ArrayAssocUtil::isAssocArray( $requestData ) );
            if ( $isBatched ) {
                $isRequestBatched = true;
            }
        }
        catch (\Exception $e) {
            //  $isRequestBatched = false;
            $responseData = array(
                'result' => null,
                'error'  => array(
                    'message' => 'Invalid request!'
                )
            );

            $this->setResponseData( $responseData );
            $this->setResponseHttpStatusHeader( self::HTTP_STATUS_HEADER_500 );
            $this->encodeResponse( $responseData );

            return $this;
        }

        $rpcQueue = array();
        if ( $isRequestBatched ) {
            $rpcQueue = $this->getRequestData();
        }
        else {
            $rpcQueue[ ] = $this->getRequestData();
        }

        $responseData = array();

        foreach ( $rpcQueue as $rpcItemData ) {

            $rpc = $this->createRpc();
            $this->setRpc( $rpc );
            if ( is_array( $rpcItemData ) ) {
                $rpc->getRpcRequestVo()
                    ->setData( $rpcItemData );
            }

            $this->handleRpc();
            $rpcResponseData = $rpc->getResponseData();

            if ( $isRequestBatched ) {
                $responseData[ ] = $rpcResponseData;
            }
            else {
                $responseData = $rpcResponseData;
            }
        }

        $this->setResponseData( $responseData );
        $this->encodeResponse( $responseData );

        return $this;
    }


    /**
     * @return $this
     */
    protected function handleRpc()
    {
        $methodQualifiedName = ClassUtil::getQualifiedMethodName(
            $this,
            __METHOD__,
            true
        );

        $rpc = $this->getRpc();

        try {
            // executeRpc
            $this->executeRpc();

            // create rpc response
            $this->createRpcResponseDataAndHandleEvents();
        }
        catch (\Exception $e) {

            $rpc->setException( $e );

            $response = array(
                'result' => null,
                'error'  => array(
                    'message' => 'Fatal API Exception ! ' . $methodQualifiedName
                                 . ' reason: ' . $e->getMessage(),
                )
            );

            $rpc->setResponseData(
                $response
            );


        }

        return $this;
    }


    // ===================== rpc ===========================

    /**
     * @return Rpc
     */
    protected function createRpc()
    {
        $factory = $this->getFactory();
        $rpc     = $factory->createRpc();

        $rpcRequestVo  = $factory->createRpcRequestVo();
        $rpcResponseVo = $factory->createRpcResponseVo();

        $rpc->setRpcRequestVo( $rpcRequestVo );
        $rpc->setRpcResponseVo( $rpcResponseVo );

        return $rpc;
    }


    /**
     * @return $this
     */
    protected function executeRpc()
    {
        $rpc = $this->getRpc();

        try {
            $this->initRpcAndHandleEvents();
            $this->routeRpcAndHandleEvents();
            $this->invokeRpcAndHandleEvents();
        }
        catch (\Exception $e) {
            $rpc->setException( $e );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initRpcAndHandleEvents()
    {
        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnBeforeInitRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnBeforeInitRpc(),
                array()
            );
        }

        $this->initRpc();

        if ( $eventHandlers->hasOnAfterInitRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnAfterInitRpc(),
                array()
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function initRpc()
    {

        $rpc           = $this->getRpc();
        $rpcRequestVo  = $rpc->getRpcRequestVo();
        $rpcResponseVo = $rpc->getRpcResponseVo();

        // set rpc.response.id (from rpc.request.id if provided)
        $rpcId   = $rpcRequestVo->getId();
        $isValid = is_scalar( $rpcId ) && ( $rpcId !== null );
        if ( $isValid ) {
            $rpcResponseVo->setId( $rpcId );
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function findRouteName()
    {
        $rpc          = $this->getRpc();
        $rpcRequestVo = $rpc->getRpcRequestVo();

        // rpc.method
        $method  = $rpcRequestVo->getMethod();
        $isValid = is_string( $method ) && ( !empty( $method ) );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid rpc.method' );
        }

        $routeName = (string)$method;

        $rpc->setRouteName( $routeName );

        return $this;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function findServiceMethodArgs()
    {
        $rpc          = $this->getRpc();
        $rpcRequestVo = $rpc->getRpcRequestVo();
        $params       = $rpcRequestVo->getParams();

        $isValid = is_array( $params );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid rpc.params' );
        }

        if ( ArrayListUtil::isArrayList( $params ) ) {
            $result = $params;
        }
        else {

            // make it a list

            $result = array(
                $params
            );
        }

        return (array)$result;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function routeRpcAndHandleEvents()
    {
        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnBeforeRouteRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnBeforeRouteRpc(),
                array()
            );
        }

        $this->routeRpc();

        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnAfterRouteRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnAfterRouteRpc(),
                array()
            );
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function routeRpc()
    {
        $rpc = $this->getRpc();

        // find routeName
        $this->findRouteName();
        $routeName = $rpc->getRouteName();
        $isValid   = is_string( $routeName ) && ( !empty( $routeName ) );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid routeName for rpc!' );
        }
        // find routeConfig by routeName
        $routes = $this->routes;
        if ( !array_key_exists( $routeName, $routes ) ) {

            throw new \Exception(
                'Route not found! routeName=' . json_encode( $routeName )
            );
        }
        $route = $routes[ $routeName ];
        $route = ArrayAssocUtil::ensureArray(
            $route,
            array(
                'serviceClass'  => null,
                'serviceMethod' => null,
            )
        );

        // find serviceMethodArgs by rpc
        $serviceMethodArgs = $this->findServiceMethodArgs();
        $isValid           = is_array( $serviceMethodArgs );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid rpc: serviceMethodArgs !' );
        }
        $rpc->setServiceMethodArgs( $serviceMethodArgs );

        // route.serviceClass
        $serviceClassName = $route[ 'serviceClass' ];
        $isValid          = ( is_string( $serviceClassName )
                              && ( !empty( $serviceClassName ) ) );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid rpc route config: serviceClass' );
        }
        // route.serviceMethod
        $serviceMethodName = $route[ 'serviceMethod' ];
        $isValid           = ( is_string( $serviceClassName )
                               && ( !empty( $serviceClassName ) ) );
        if ( !$isValid ) {

            throw new \Exception( 'Invalid rpc route config: serviceMethod' );
        }

        $factory = $this->getFactory();

        $serviceMethodReflector = null;
        try {
            $serviceClassReflector = new \ReflectionClass( $serviceClassName );

            $serviceMethodReflector = $serviceClassReflector->getMethod(
                $serviceMethodName
            );
            $rpc->setServiceMethodName( $serviceMethodReflector->getName() );

            $serviceInstance = $serviceClassReflector->newInstanceArgs(
                array(
                    $factory,
                    $rpc
                )
            );
            /** @var RpcService $serviceInstance */
            $rpc->setServiceClassInstance( $serviceInstance );

        }
        catch (\Exception $e) {

            throw new \Exception(
                'Invalid rpc route config. Service/Method not invokable. '
                . $e->getMessage()
            );
        }

        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function invokeRpcAndHandleEvents()
    {
        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnBeforeInvokeRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnBeforeInvokeRpc(),
                array()
            );
        }

        $this->invokeRpc();

        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnAfterInvokeRpc() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnAfterInvokeRpc(),
                array()
            );
        }


        return $this;
    }

    /**
     * @return $this
     * @throws \Exception
     */
    protected function invokeRpc()
    {
        $rpc                  = $this->getRpc();
        $serviceClassInstance = $rpc->getServiceClassInstance();
        $serviceMethodName    = $rpc->getServiceMethodName();
        $serviceMethodArgs    = $rpc->getServiceMethodArgs();

        $callable = array( $serviceClassInstance, $serviceMethodName );
        if ( !is_callable( $callable ) ) {

            throw new \Exception(
                'Service Method not callable! '
                . ClassUtil::getQualifiedMethodName(
                    $serviceClassInstance,
                    $serviceMethodName,
                    true
                    . ' at: ' . __METHOD__
                )
            );
        }

        try {
            $serviceMethodResult = call_user_func_array(
                $callable,
                $serviceMethodArgs
            );
            $rpc->setServiceMethodResult( $serviceMethodResult );
        }
        catch (\Exception $e) {
            $rpc->setException( $e );
        }

        return $this;
    }


    /**
     * @return $this
     */
    protected function createRpcResponseDataAndHandleEvents()
    {
        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnBeforeCreateRpcResponseData() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnBeforeCreateRpcResponseData(),
                array()
            );
        }

        $this->createRpcResponseData();

        $eventHandlers = $this->getEventHandlers();
        if ( $eventHandlers->hasOnAfterCreateRpcResponseData() ) {
            $this->invokeEventHandler(
                $eventHandlers->getOnAfterCreateRpcResponseData(),
                array()
            );
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function createRpcResponseData()
    {
        $rpc           = $this->getRpc();
        $rpcResponseVo = $rpc->getRpcResponseVo();

        if ( $rpc->hasException() ) {
            $error = ExceptionUtil::exceptionAsArray(
                $rpc->getException(),
                true
            );

            $rpcResponseVo->setError(
                $error
            );

            $rpcResponseVo->setResult( null );

        }
        else {
            $rpcResponseVo->setResult(
                $rpc->getServiceMethodResult()
            );
        }

        if ( $rpc->hasResponseHttpStatusHeader() ) {
            $httpStatusHeader = $rpc->getResponseHttpStatusHeader();
            $this->setResponseHttpStatusHeader( $httpStatusHeader );
        }

        $responseData             = $rpcResponseVo->getData();
        $responseData[ 'result' ] = $rpcResponseVo->getResult();
        $responseData[ 'error' ]  = $rpcResponseVo->getError();

        $isDebugEnabled = $rpc->getIsDebugEnabled();
        if ( is_array( $responseData[ 'error' ] ) && !$isDebugEnabled ) {

            $responseData[ 'error' ] = ArrayAssocUtil::keepKeys(
                $responseData[ 'error' ],
                array(
                    'class',
                    'message',
                    'type',
                    'data',
                )
            );
        }

        $rpc->setResponseData( $responseData );

        return $this;
    }

    // ===================== request ===========================

    /**
     * @return string
     */
    public function fetchRequestText()
    {
        $requestText = (string)file_get_contents( "php://input" );

        return $requestText;
    }


    // ===================== response ===========================

    /**
     * @param array $responseData
     */
    protected function encodeResponse( $responseData )
    {
        //$responseText = '';
        try {
            if ( !is_array( $responseData ) ) {

                throw new \Exception( 'Invalid response!' );
            }
            $responseText = JsonEncoderUtil::encode( $responseData, true );
        }
        catch (\Exception $e) {
            $this->setException( $e );
            $result       = null;
            $error        = array(
                'message' => 'json encode rpc.response failed',
            );
            $responseData = array(
                'result' => $result,
                'error'  => $error,
            );
            $responseText = JsonEncoderUtil::encode( $responseData, true );
        }

        $this->setResponseText( $responseText );
    }

    /**
     * @return $this
     */
    public function sendResponse()
    {
        $responseStatusHeader = $this->getResponseHttpStatusHeader();

        try {
            header( 'Content-type: application/json' );
        }
        catch (\Exception $e) {
            // nop
        }

        $hasStatusHeader = is_string( $responseStatusHeader )
                           && ( !empty( $responseStatusHeader ) );
        if ( $hasStatusHeader ) {
            try {
                header( $responseStatusHeader );
            }
            catch (\Exception $e) {
                // nop
            }
        }

        echo $this->getResponseText();

        return $this;
    }


    // =============================

    /**
     * @var RpcRouterEventHandlers
     */
    protected $eventHandlers;

    /**
     * @return RpcRouterEventHandlers
     */
    public function getEventHandlers()
    {
        if ( !$this->eventHandlers ) {
            $this->eventHandlers = $this->getFactory()
                                        ->createRouterEventHandlers();
        }

        return $this->eventHandlers;
    }

    /**
     * @param RpcCallback $rpcCallback
     * @param array       $customArgs
     *
     * @return mixed
     * @throws \Exception
     */
    protected function invokeEventHandler(
        RpcCallback $rpcCallback,
        $customArgs
    )
    {
        if ( !is_array( $customArgs ) ) {
            $customArgs = array();
        }


        $closure = $rpcCallback->getClosure();

        if ( !is_callable( $closure ) ) {

            throw new \Exception(
                'Property "closure" is not callable! ' . __METHOD__
            );
        }

        $closureParams = $rpcCallback->getParams();

        $callbackArgs = array(
            $this
        );

        foreach ( $customArgs as $arg ) {
            $callbackArgs[ ] = $arg;
        }

        foreach ( $closureParams as $arg ) {
            $callbackArgs[ ] = $arg;
        }

        return call_user_func_array( $closure, $callbackArgs );
    }

}