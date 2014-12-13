<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 10:24 AM
 */

namespace Application\Api\RateSeat\V1\Shared;


use Application\Definition\UfloatTypeNotEmpty;
use Application\Definition\UintTypeNotEmpty;
use
    Application\Lib\RateSeat\RestApiClient\Api\Base\Request\BaseRateSeatApiClientRequest;
use Application\Lib\RateSeat\RestApiClient\HttpClientOptionsVo;
use Application\Lib\RateSeat\RestApiClient\RateSeatRestApiClient;
use Application\Lib\RateSeat\RestApiClient\RateSeatRestApiClientConfigVo;
use Application\Mvo\ApplicationSettings\RateSeatApiClientSettingsVo;
use Application\Utils\ClassUtil;

/**
 * Class RateSeatApiClientFacade
 * @package Application\Api\RateSeat\V1\Shared
 */
class RateSeatApiClientFacade
{


    /**
     * @var RateSeatApiClientSettingsVo
     */
    protected $apiClientSettingsVo;

    /**
     * @param RateSeatApiClientSettingsVo $rateSeatApiClientSettingsVo
     */
    public function __construct(
        RateSeatApiClientSettingsVo $rateSeatApiClientSettingsVo
    )
    {
        $this->apiClientSettingsVo = $rateSeatApiClientSettingsVo;
    }

    /**
     * @return RateSeatApiClientSettingsVo
     */
    protected function getApiClientSettingsVo()
    {
        return $this->apiClientSettingsVo;
    }


    /**
     * @var RateSeatRestApiClientConfigVo
     */
    protected $restApiClientConfigVo;

    /**
     * @return RateSeatRestApiClientConfigVo
     */
    public function createRestApiClientConfig()
    {
        $vo                          = new RateSeatRestApiClientConfigVo();
        $this->restApiClientConfigVo = $vo;


        $apiClientSettingsVo = $this->getApiClientSettingsVo();
        //@TODO: use proper setters instead of setData
        $vo->setData(
            array(
                $vo::KEY_API_BASE_URI => $apiClientSettingsVo->getApiBaseUri(),
                $vo::KEY_API__TOKEN   => $apiClientSettingsVo->getApiToken()
            )
        );

        return $vo;
    }


    /**
     * @return RateSeatRestApiClientConfigVo
     */
    public function getRestApiClientConfigVo()
    {
        if ( !$this->restApiClientConfigVo ) {

            $vo = $this->createRestApiClientConfig();
            $vo->validate();
            $this->restApiClientConfigVo = $vo;

        }

        return $this->restApiClientConfigVo;
    }


    /**
     * @var HttpClientOptionsVo
     */
    protected $httpClientOptionsVo;

    /**
     * @return HttpClientOptionsVo
     */
    public function createHttpClientOptionsVo()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $vo = new HttpClientOptionsVo();

        // apply defaults
        $apiClientSettingsVo = $this->getApiClientSettingsVo();
        $connectTimeoutValue = $apiClientSettingsVo->getApiConnectTimeout();
        $requestTimeoutValue = $apiClientSettingsVo->getApiRequestTimeout();

        $connectTimeout = new UfloatTypeNotEmpty(
            $connectTimeoutValue,
            'Invalid connectTimeout: ' . json_encode(
                $connectTimeoutValue
            ) . ' !'
            . ' Must be ufloat type - not empty!'
            . ' (' . $method . ')'
        );
        $vo->setConnectTimeout( $connectTimeout );

        $requestTimeout = new UfloatTypeNotEmpty(
            $requestTimeoutValue,
            'Invalid requestTimeout: ' . json_encode(
                $requestTimeoutValue
            ) . ' !'
            . ' Must be ufloat type - not empty!'
            . ' (' . $method . ')'
        );
        $vo->setRequestTimeout( $requestTimeout );

        return $vo;
    }

    /**
     * @return HttpClientOptionsVo
     */
    public function getHttpClientOptionsVo()
    {
        if ( !$this->httpClientOptionsVo ) {

            $vo                        = $this->createHttpClientOptionsVo();
            $this->httpClientOptionsVo = $vo;

        }

        return $this->httpClientOptionsVo;
    }


    /**
     * @param RateSeatRestApiClientConfigVo $clientConfigVo
     *
     * @return RateSeatRestApiClient
     */
    public function createRestApiClient(
        RateSeatRestApiClientConfigVo $clientConfigVo
    )
    {
        return new RateSeatRestApiClient(
            $clientConfigVo
        );
    }


    /**
     * @param RateSeatRestApiClientConfigVo $rateSeatRestApiClientConfigVo
     * @param HttpClientOptionsVo           $httpClientOptionsVo
     * @param BaseRateSeatApiClientRequest  $rateSeatApiClientRequest
     * @param UintTypeNotEmpty              $rateSeatRequestNonceTimestamp
     *
     * @return \Application\Lib\RateSeat\RateSeatRestApiClientGuzzleStatus
     */
    public function makeRequest(
        RateSeatRestApiClientConfigVo $rateSeatRestApiClientConfigVo,
        HttpClientOptionsVo $httpClientOptionsVo,
        BaseRateSeatApiClientRequest $rateSeatApiClientRequest,
        UintTypeNotEmpty $rateSeatRequestNonceTimestamp
    )
    {

        $restApiClient = $this->createRestApiClient(
            $rateSeatRestApiClientConfigVo
        );

        $guzzleStatus  = $restApiClient->makeRequestGuzzle(
            $rateSeatApiClientRequest->getHttpMethod(),
            $rateSeatApiClientRequest->getResourceUri(),
            $rateSeatApiClientRequest->getCurlData(),
            $rateSeatRequestNonceTimestamp,
            $httpClientOptionsVo
        );

        return $guzzleStatus;
    }


}