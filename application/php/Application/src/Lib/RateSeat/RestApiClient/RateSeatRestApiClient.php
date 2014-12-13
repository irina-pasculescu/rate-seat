<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/10/14
 * Time: 4:27 PM
 */

namespace Application\Lib\RateSeat\RestApiClient;

use Application\Definition\UintTypeNotEmpty;
use Application\Lib\RateSeat\RestApiClient\RequestBuilder\RateSeatRequestBuilder;
use Application\Lib\RateSeat\RateSeatRestApiClientGuzzleStatus;
use Guzzle\Http\Client as GuzzleHttpClient;

/**
 * Class RateSeatRestApiClient
 * @package Application\Lib\RateSeatApi\RestApiClient
 */
class RateSeatRestApiClient
{

    const HTTP_METHOD_POST = 'POST';
    const HTTP_METHOD_GET = 'GET';

    /**
     * @param RateSeatRestApiClientConfigVo $clientConfigVo
     */
    public function __construct(RateSeatRestApiClientConfigVo $clientConfigVo)
    {
        $this->setClientConfigVo($clientConfigVo);
    }

    /**
     * @var GuzzleHttpClient
     */
    private $guzzleClient;

    /**
     * @return GuzzleHttpClient
     */
    public function getGuzzleClient()
    {
        if (!$this->guzzleClient) {
            $this->guzzleClient = new GuzzleHttpClient();
        }

        return $this->guzzleClient;
    }


    /**
     * @var RateSeatRestApiClientConfigVo
     */
    private $clientConfigVo;

    /**
     * @param RateSeatRestApiClientConfigVo $value
     *
     * @return $this
     */
    public function setClientConfigVo(RateSeatRestApiClientConfigVo $value)
    {
        $this->clientConfigVo = $value;

        return $this;
    }

    /**
     * @return RateSeatRestApiClientConfigVo
     */
    public function getClientConfigVo()
    {
        return $this->clientConfigVo;
    }


    public function makeRequestCurl(
        $httpMethod,
        $requestUri,
        $requestData,
        UintTypeNotEmpty $nonceTimestamp
    ) {
        $configVo = $this->getClientConfigVo();
        $apiHost = $configVo->getApiHost();

        $base_URI = $configVo->getApiBaseUri();

        $request_method = $httpMethod;
        $canonical_URI = $requestUri;

        $headers = array();
        $headers[] = 'Accept: application/json';

        $postFields = $requestData;

        $curlData = array(
            'url' => $base_URI . $canonical_URI,
            'customRequest' => $request_method,
            'postFields' => $postFields,
            'returnTransfer' => true,
            'headers' => $headers,
        );

        ksort($curlData);
        echo PHP_EOL . PHP_EOL . json_encode($curlData) . PHP_EOL . PHP_EOL;


        $ch = curl_init($curlData['url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $curlData['returnTransfer']);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $curlData['headers']);

        $startTs = microtime(true);
        $resultText = curl_exec($ch);
        $stopTs = microtime(true);

        $resultData = json_decode($resultText, true);


        var_dump(
            array(

                'curlResponse' => $resultData,
                'duration' => $stopTs - $startTs,
            )
        );

        return $this;
    }


    /**
     * @param $httpMethod
     * @param $requestUri
     * @param $requestData
     * @param UintTypeNotEmpty $nonceTimestamp
     * @param HttpClientOptionsVo $httpClientOptionsVo
     * @return RateSeatRestApiClientGuzzleStatus
     */
    public function makeRequestGuzzle(

        $httpMethod,
        $requestUri,
        $requestData,
        UintTypeNotEmpty $nonceTimestamp,
        HttpClientOptionsVo $httpClientOptionsVo
    ) {

        $requestBuilder = new RateSeatRequestBuilder(
            $this->getClientConfigVo()
        );

        $rateSeatRequest = $requestBuilder->createRequest(
            $httpMethod,
            $requestUri,
            $requestData
        );
        $rateSeatRequestSigned = $requestBuilder->createRequestSigned(
            $rateSeatRequest,
            $nonceTimestamp
        );
        $rateSeatRequestSigned->signRequest();

        $curlData = array(
            'returnTransfer' => true,
            'url' => (string)$rateSeatRequestSigned->getRequestUrlInfo(),
            'headers' => $rateSeatRequestSigned->getRequestHeaders(),
        );

        $guzzleClient = $this->getGuzzleClient();

        $guzzleRequestHeadersDict = array();
        $curlRequestHeadersList = $curlData['headers'];
        foreach ($curlRequestHeadersList as $requestHeader) {
            $parts = (array)explode(':', (string)$requestHeader);
            $headerName = trim((string)array_shift($parts));
            if ($headerName === '') {

                continue;
            }

            $headerValue = (string)implode(':', (array)$parts);
            $guzzleRequestHeadersDict[$headerName] = $headerValue;
        }

        $guzzleRequest = $guzzleClient->get(
            (string)$rateSeatRequestSigned->getRequestUrlInfo(),
            $guzzleRequestHeadersDict,
            array(),
            $httpClientOptionsVo->getData()
        );
        $clientStatus = new RateSeatRestApiClientGuzzleStatus(
            $guzzleRequest
        );

        try {
            $clientStatus->startProfiling();
            $guzzleRequest->send();
            $clientStatus->stopProfiling();
        } catch (\Exception $e) {
            $clientStatus->stopProfiling();
            // do not delegate
            $clientStatus->setException($e);
        }


        $clientStatus->decodeResponseBodyData();

        return $clientStatus;
    }


    /**
     * @param $httpMethod
     * @param $requestUri
     * @param $requestData
     * @param UintTypeNotEmpty $nonceTimestamp
     * @param HttpClientOptionsVo $httpClientOptionsVo
     * @return \Guzzle\Http\Message\Response
     */
    public function makeRequestGuzzleDebug(

        $httpMethod,
        $requestUri,
        $requestData,
        UintTypeNotEmpty $nonceTimestamp,
        HttpClientOptionsVo $httpClientOptionsVo
    ) {

        $requestBuilder = new RateSeatRequestBuilder(
            $this->getClientConfigVo()
        );
        $rateSeatRequest = $requestBuilder->createRequest(
            $httpMethod,
            $requestUri,
            $requestData
        );
        $rateSeatRequestSigned = $requestBuilder->createRequestSigned(
            $rateSeatRequest,
            $nonceTimestamp
        );
        $rateSeatRequestSigned->signRequest();


        $curlData = array(
            'returnTransfer' => true,
            'url' => (string)$rateSeatRequestSigned->getRequestUrlInfo(),
            'headers' => $rateSeatRequestSigned->getRequestHeaders(),
        );


        ksort($curlData);
        echo PHP_EOL . PHP_EOL . json_encode($curlData) . PHP_EOL . PHP_EOL;


        $guzzleClient = $this->getGuzzleClient();

        $guzzleRequestHeadersDict = array();
        $curlRequestHeadersList = $curlData['headers'];
        foreach ($curlRequestHeadersList as $requestHeader) {
            $parts = (array)explode(':', (string)$requestHeader);
            $headerName = trim((string)array_shift($parts));
            if ($headerName === '') {

                continue;
            }

            $headerValue = (string)implode(':', (array)$parts);
            $guzzleRequestHeadersDict[$headerName] = $headerValue;
        }


        $guzzleRequest = $guzzleClient->get(
            $curlData['url'],
            $guzzleRequestHeadersDict,
            array(),
            $httpClientOptionsVo->getData()
        );

        echo PHP_EOL . PHP_EOL . (string)$guzzleRequest . PHP_EOL . PHP_EOL;

        $guzzleResponse = $guzzleRequest->send();
        $responseBodyText = (string)$guzzleResponse
            ->getBody(true);
        $responseBodyData = json_decode($responseBodyText, true);
        $httpStatusCode = $guzzleResponse->getStatusCode();

        /*
        $debug = array(
            'httpStatusCode' => $httpStatusCode,
            'responseData' => $responseBodyData,
        );
        */


        //echo PHP_EOL.PHP_EOL.json_encode($debug).PHP_EOL.PHP_EOL;


        return $guzzleResponse;


    }


} 