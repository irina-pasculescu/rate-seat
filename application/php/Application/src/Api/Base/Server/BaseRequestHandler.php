<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/9/14
 * Time: 10:36 AM
 */

namespace Application\Api\Base\Server;

use Application\Api\Base\Server\BaseRequestVo as RequestVo;
use Application\Api\Base\Server\BaseResponseVo as ResponseVo;
use Application\Api\RateSeat\V1\Shared\RateSeatApiClientFacade;
use Application\Api\RateSeat\V1\Shared\RateSeatApiSettingsManager;
use Application\Context;
use Application\Definition\UintTypeNotEmpty;


/**
 * Class BaseRequestHandler
 *
 * @package Application\Api\Base\Server
 */
abstract class BaseRequestHandler
{


    /**
     * @var float
     */
    protected $requestMicroTimestamp = 0.0;

    /**
     * @var RpcContext
     */
    protected $rpcContext;

    /**
     *
     */
    public function __construct( RpcContext $rpcContext )
    {
        $this->rpcContext            = $rpcContext;
        $this->requestMicroTimestamp = microtime( true );

    }

    /**
     * @return RpcContext
     */
    protected function getRpcContext()
    {
        return $this->rpcContext;
    }

    /**
     * @return float
     */
    protected function getRequestMicroTimestamp()
    {
        return (float)$this->requestMicroTimestamp;
    }

    /**
     * @var \DateTime
     */
    protected $requestDateTime;

    /**
     * @return \DateTime
     */
    protected function getRequestDateTime()
    {
        if ( !$this->requestDateTime ) {
            $this->requestDateTime = new \DateTime();
            $timestamp             = (int)floor( $this->getRequestMicroTimestamp() );
            $this->requestDateTime->setTimestamp( $timestamp );
        }

        return $this->requestDateTime;
    }

    /**
     * @return UintTypeNotEmpty
     */
    protected function getRequestTimestamp()
    {
        return new UintTypeNotEmpty(
            $this->getRequestDateTime()->getTimestamp()
        );
    }

    /**
     * @param array $request
     *
     * @return array
     * @throws \Exception
     */
    public function handleRequest( $request )
    {
        try {

            $this->getRequestVo()->setData( $request );

            $this->validateRequest();

            $this->execute();

            $this->onSuccess();

            return $this->exportResponse();

        }
        catch (\Exception $e) {

            var_dump( $e->getMessage() );
            die();

            throw $e;
        }
    }

    /**
     * @return $this
     */
    protected function onBeforeValidateRequest()
    {


        return $this;
    }

    /**
     * @return $this
     */
    protected function validateRequest()
    {
        $this->onBeforeValidateRequest();

        $this->getRequestVo()->validate();

        return $this;
    }

    /**
     * @return array
     */
    protected function exportResponse()
    {
        return $this->getResponseVo()->export();
    }

    /**
     * @var RequestVo
     */
    protected $requestVo;

    /**
     * @return RequestVo
     */
    abstract protected function getRequestVo();


    /**
     * @var ResponseVo
     */
    protected $responseVo;

    /**
     * @return ResponseVo
     */
    abstract protected function getResponseVo();


    /**
     * @throws \Exception
     * @return $this
     */
    abstract protected function execute();

    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    protected function onException( \Exception $exception )
    {
        return $this;
    }

    /**
     * @return $this
     */
    protected function onSuccess()
    {
        return $this;
    }


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
        return $this->getApplicationContext()
                    ->getModel();
    }

    /**
     * @var RateSeatApiClientFacade
     */
    private $rateSeatApiClientFacade;

    /**
     * @return RateSeatApiClientFacade
     */
    protected function getRateSeatApiClientFacade()
    {
        if ( !$this->rateSeatApiClientFacade ) {
            $settingsManager = RateSeatApiSettingsManager::getInstance();

            $this->rateSeatApiClientFacade = new RateSeatApiClientFacade(
                $settingsManager->getApiClientSettingsVo()
            );
        }

        return $this->rateSeatApiClientFacade;
    }
} 