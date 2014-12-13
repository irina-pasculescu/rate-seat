<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:39 AM
 */
namespace Application\Api\Base\Server;

use Application\Api\Base\Server\ApiManagerSettingsVo as SettingsVo;
use Application\Context;
use Application\Profiler;
use Application\Utils\ArrayAssocUtil;
use Application\Utils\ClassUtil;
use Application\Utils\ExceptionUtil;
use Application\Utils\StringUtil;

/**
 * Class ApiManager
 *
 * @package Application\Api\Base\Server
 */
abstract class ApiManager
{

    /**
     * @param RpcFactory $rpcFactory
     */
    public function __construct( RpcFactory $rpcFactory )
    {
        $this->rpcFactory = $rpcFactory;
    }


    /**
     * @var RpcFactory
     */
    protected $rpcFactory;

    /**
     * @return RpcFactory
     */
    abstract public function getRpcFactory();


    /**
     * @return Context
     */
    protected function getApplicationContext()
    {
        return Context::getInstance();
    }

    /**
     * @return \Application\Model
     */
    protected function getModel()
    {
        return $this->getApplicationContext()->getModel();
    }

    // ================== overrides ================


    /**
     * @var SettingsVo;
     */
    protected $settingsVo;


    /**
     *
     * @return SettingsVo
     */
    abstract public function getSettingsVo();


    /**
     * @return string
     */
    abstract public function getFeatureName();


    /**
     * @return bool
     */
    public function isEnabled()
    {
        return ( $this->getSettingsVo()->getEnabled() === true );
    }

    /**
     * @param string|null $errorDetailsText
     *
     * @return null
     * @throws \Exception
     */
    public function requireIsEnabled( $errorDetailsText = '' )
    {
        $result = null;
        if ( $this->isEnabled() ) {

            return $result;
        }
        if ( !is_string( $errorDetailsText ) ) {
            $errorDetailsText = '';
        }

        $message = StringUtil::joinStrictIfNotEmpty(
            ' ',
            array(
                'Feature not enabled.',
                'feature=' . json_encode( $this->getFeatureName() ),
                'method='
                . ClassUtil::getQualifiedMethodName( $this, __METHOD__, true ),
                $errorDetailsText
            )
        );

        throw new \Exception(
            $message
        );
    }

    // ============  custom feature logic =================

    /**
     * @var array
     */
    protected $routes
        = array( /*
        'Example.Test.ping' => array(
            'target' =>
                '\\Application\\Api\\V1\\Example\\Service\\Test::ping'
        ),
     */

        );


    // ============ routes =============================

    /**
     * @return array
     */
    protected function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return array
     */
    protected function getRoutesHttp()
    {
        return $this->getRoutes();
    }


    /**
     *
     */
    public function initRoutesHttp()
    {

        $routes = $this->getRoutesHttp();
        $this->applyRoutes( $routes );
    }

    /**
     * @param $routes
     *
     * @return $this
     * @throws \Exception
     */
    protected function applyRoutes( $routes )
    {

        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();

        if ( !is_array( $routes ) ) {

            throw new \Exception( 'Invalid parameter "routes" ! ' . __METHOD__ );
        }


        foreach ( $routes as $rpcMethod => $routeConfig ) {

            $qualifiedMethodName      = (string)$routeConfig[ 'target' ];
            $qualifiedMethodNameParts = (array)explode(
                '::',
                $qualifiedMethodName
            );

            $className  = $qualifiedMethodNameParts[ 0 ];
            $methodName = $qualifiedMethodNameParts[ 1 ];

            $router->addRoute( $rpcMethod, $className, $methodName );
        }

        return $this;

    }


    // ========== router: callbacks ============================
    /**
     * @return $this
     */
    public function initRouterCallbacks()
    {
        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();

        $eventHandlers = $router->getEventHandlers();
        $apiManager    = $this;

        // initRpc
        $eventHandlers->setOnBeforeInitRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onBeforeInitRpc();
                },
                array(
                    $apiManager
                )
            )
        );


        $eventHandlers->setOnAfterInitRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onAfterInitRpc();
                },
                array(
                    $apiManager
                )
            )
        );

        // invokeRpc
        $eventHandlers->setOnBeforeInvokeRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onBeforeInvokeRpc();
                },
                array(
                    $apiManager
                )
            )
        );

        $eventHandlers->setOnAfterInvokeRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onAfterInvokeRpc();
                },
                array(
                    $apiManager
                )
            )
        );

        // routeRpc
        $eventHandlers->setOnBeforeRouteRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onBeforeRouteRpc();
                },
                array(
                    $apiManager
                )
            )
        );
        $eventHandlers->setOnAfterRouteRpc(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onAfterRouteRpc();
                },
                array(
                    $apiManager
                )
            )
        );

        // createRpcResponseData

        $eventHandlers->setOnBeforeCreateRpcResponseData(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onBeforeCreateRpcResponseData();
                },
                array(
                    $apiManager
                )
            )
        );

        $eventHandlers->setOnAfterCreateRpcResponseData(
            $rpcFactory->createRouterCallback(
                function ( $router, ApiManager $apiManager ) {
                    $apiManager->onAfterCreateRpcResponseData();
                },
                array(
                    $apiManager
                )
            )
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function onBeforeInitRpc()
    {

        return $this;
    }

    /**
     * @return $this
     */
    public function onAfterInitRpc()
    {
        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();
        $rpc        = $router->getRpc();

        $settingsVo = $this->getSettingsVo();

        $rpc->setIsDebugEnabled(
            $settingsVo
                ->getIsDebugEnabled()
        );

        return $this;
    }

    /**
     * @return $this
     */
    public function onBeforeRouteRpc()
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function onAfterRouteRpc()
    {
        return $this;
    }

    /**
     * @return $this
     */
    public function onBeforeInvokeRpc()
    {
        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();

        // check api is enabled
        $this->requireIsEnabled();

        $rpc = $router->getRpc();

        // oboe tag request by using current route
        $this->getProfiler()->oboeTagControllerAction(
            $this->getFeatureName(),
            $rpc->getRouteName()
        );

        $profilerKey = $this->getApiProfilerKey(
            'route.' . $rpc->getRouteName() . '.invokeRpc'
        );

        $this->profileDurationStart( $profilerKey, true, true, true );


        $this->prepareContext();

        return $this;
    }

    /**
     * @return $this
     */
    public function onAfterInvokeRpc()
    {
        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();
        // you may want to persist model repositories,
        // or just do some magic stuff.

        $profiler = $this->getProfiler();

        $rpc = $router->getRpc();
        // execute api context business logic
        $profilerKey = $this->getApiProfilerKey(
            'route.' . $rpc->getRouteName() . '.invokeRpc'
        );
        $profiler->stopTrackingByKey( $profilerKey );

        if ( $rpc->hasException() ) {
            throw \Exception( $rpc->getException()->getMessage() );
        }


        // mixin debug log to rpc client response
        $debug = $rpc->getDebug();
        if ( !is_array( $debug ) ) {
            $debug = array();
        }

        $profiler->stopTrackingByKey( 'application' );
        $profiler->stop();
        $debug[ 'profiler' ] = $profiler->getItems();

        $rpc->getRpcResponseVo()
            ->setDebug( $debug );


        return $this;
    }


    /**
     * @return $this
     */
    public function onBeforeCreateRpcResponseData()
    {

        return $this;
    }


    /**
     * @return $this
     */
    public function onAfterCreateRpcResponseData()
    {

        $rpcFactory = $this->getRpcFactory();
        $router     = $rpcFactory->getRouter();
        $rpc        = $router->getRpc();

        $rpcResponseData = $rpc->getResponseData();

        if ( $rpc->hasException() ) {
            $this->logRpcException();
        }
        else {
            $this->logRpcSuccess();
        }


        $isDebugEnabled = $rpc->getIsDebugEnabled();
        if ( !$isDebugEnabled ) {
            $rpcResponseData = ArrayAssocUtil::removeKeys(
                $rpcResponseData,
                array(
                    'debug',
                )
            );
        }

        $rpc->setResponseData( $rpcResponseData );

        return $this;
    }



    /**
     * @return $this
     */
    protected function logRpcSuccess()
    {
        return $this;
    }

    /**
     * @return $this
     */
    protected function logRpcException()
    {
        return $this;
    }


    /**
     * @return Profiler
     */
    protected function getProfiler()
    {
        return $this->getApplicationContext()
                    ->getProfiler();
    }

    /**
     * @param string $suffix
     *
     * @return string
     */
    protected function getApiProfilerKey( $suffix )
    {

        $featureName = $this->getFeatureName();
        // execute api context business logic

        $parts = array(
            $featureName,
            $suffix
        );

        return (string)ClassUtil::toJavaStyle(
            StringUtil::joinStrictIfNotEmpty(
                '.',
                $parts
            )
        );
    }

    /**
     * @param string $key
     * @param bool   $useApplicationProfiler
     * @param bool   $useStatsD
     * @param bool   $useOboe
     *
     * @return $this
     */
    protected function profileDurationStart(
        $key,
        $useApplicationProfiler,
        $useStatsD,
        $useOboe
    )
    {
        $profiler = $this->getProfiler();
        if ( $useOboe ) {
            $profiler->oboeStart( $key );
        }
        if ( $useApplicationProfiler ) {
            $profiler->startTrackingByKey( $key );
        }

        return $this;
    }

    /**
     * @param string $key
     * @param bool   $useApplicationProfiler
     * @param bool   $useStatsD
     * @param bool   $useOboe
     *
     * @return $this
     */
    protected function profileDurationStop(
        $key,
        $useApplicationProfiler,
        $useStatsD,
        $useOboe
    )
    {
        $profiler = $this->getProfiler();
        if ( $useApplicationProfiler ) {
            $profiler->stopTrackingByKey( $key );
        }

        if ( $useOboe ) {
            $profiler->oboeStop( $key );
        }

        return $this;
    }

    /**
     * @return array
     */
    public function describe()
    {
        $result = array(
            'name'     => $this->getFeatureName(),
            'enabled'  => $this->isEnabled(),
            'manager'  => ClassUtil::getClassNameAsJavaStyle( $this ),
            'settings' => $this->getSettingsVo()->getData(),
            'routes'   => array(
                'http' => null,
            ),
            'handlers' => array(),
        );

        $routesHttp = $this->getRoutesHttp();

        foreach ( $routesHttp as $routeName => $routeInfo ) {
            if ( !is_array( $routeInfo ) ) {

                continue;
            }

            $routesHttp[ $routeName ] = $routeInfo;
        }


        $result[ 'routes' ][ 'http' ] = $routesHttp;
        $handlers                     = array();


        foreach ( $routesHttp as $routeName => $routeInfo ) {

            if ( !is_array( $routeInfo ) ) {

                continue;
            }

            $routeInfo = ArrayAssocUtil::ensureArray(
                $routeInfo,
                array(
                    'target' => null,
                )
            );

            $handler = $routeInfo[ 'target' ];

            $handlers[ $handler ][ ] = array(
                'http'   => $routeName,
                'config' => $routeInfo,
            );
        }

        $result[ 'handlers' ] = $handlers;

        return $result;
    }


    /**
     *
     * @return $this
     */
    abstract protected function prepareContext();


}