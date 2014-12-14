<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 1:16 PM
 */

namespace Application\Lib\RateSeat;


use Application\Utils\ClassUtil;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;

/**
 * Class RateSeatRestApiClientGuzzleStatus
 * @package Application\Lib\RateSeat
 */
class RateSeatRestApiClientGuzzleStatus
{

    /**
     * @param RequestInterface $guzzleRequest
     */
    public function __construct( RequestInterface $guzzleRequest )
    {
        $this->guzzleRequest = $guzzleRequest;
    }


    /**
     * @var \Exception|null
     */
    protected $exception;

    /**
     * @param \Exception $exception
     *
     * @return $this
     */
    public function setException( \Exception $exception )
    {
        $this->exception = $exception;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasException()
    {
        return $this->exception instanceof \Exception;
    }

    /**
     * @return \Exception|null
     * @throws \OutOfBoundsException
     */
    public function getException()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );
        if ( !$this->hasException() ) {

            throw new \OutOfBoundsException(
                'Property not set: exception!'
                . ' (' . $method . ')'
            );
        }

        return $this->exception;
    }


    /**
     * @var RequestInterface
     */
    protected $guzzleRequest;


    /**
     * @return RequestInterface
     */
    public function getGuzzleRequest()
    {
        return $this->guzzleRequest;
    }

    /**
     * @return string
     */
    public function getRequestText()
    {
        return (string)$this->getGuzzleRequest();
    }


    /**
     * @return bool
     */
    public function hasGuzzleResponse()
    {
        return $this->getGuzzleRequest()->getResponse() !== null;
    }

    /**
     * @return Response
     * @throws \OutOfBoundsException
     */
    public function getGuzzleResponse()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );
        if ( !$this->hasGuzzleResponse() ) {

            throw new \OutOfBoundsException(
                'Property not set: guzzleResponse!'
                . ' (' . $method . ')'
            );
        }

        return $this->getGuzzleRequest()->getResponse();
    }


    /**
     * @return string
     */
    public function getResponseText()
    {
        if ( !$this->hasGuzzleResponse() ) {

            return '';
        }

        return (string)$this->getGuzzleResponse();
    }

    /**
     * @return string
     */
    public function getResponseBodyText()
    {
        if ( !$this->hasGuzzleResponse() ) {

            return '';
        }

        return (string)$this->getGuzzleResponse()->getBody( true );
    }


    /**
     * @var string
     */
    protected $responseBodyData = null;

    /**
     * @return $this
     */
    public function decodeResponseBodyData()
    {
        $text = $this->getResponseBodyText();
        if ( trim( $text ) !== '' ) {

            $this->responseBodyData = json_decode( $text, true );
        }

        return $this;
    }

    /**
     * @return array|null
     */
    public function getResponseBodyData()
    {
        $value = $this->responseBodyData;
        if ( is_array( $value ) ) {

            return (array)$value;
        }

        return null;
    }

    /**
     * @return int
     */
    public function getResponseHttpStatusCode()
    {
        if ( $this->hasGuzzleResponse() ) {

            return (int)$this->getGuzzleResponse()->getStatusCode();
        }

        return 0;
    }


    /**
     * @var float
     */
    protected $startMicroTime = 0.0;

    /**
     * @return $this
     */
    public function startProfiling()
    {
        $this->startMicroTime = microtime( true );

        return $this;
    }

    /**
     * @return float
     */
    public function getStartMicroTime()
    {
        return (float)$this->startMicroTime;
    }


    /**
     * @var float
     */
    protected $stopMicroTime = 0.0;

    /**
     * @return $this
     */
    public function stopProfiling()
    {
        $this->stopMicroTime = microtime( true );

        return $this;
    }

    /**
     * @return float
     */
    public function getStopMicroTime()
    {
        return (float)$this->stopMicroTime;
    }

    /**
     * @return float
     */
    public function getDuration()
    {
        $duration = $this->getStopMicroTime() - $this->getStartMicroTime();
        if ( $duration < 0 ) {
            $duration = 0;
        }

        return (float)$duration;
    }

} 