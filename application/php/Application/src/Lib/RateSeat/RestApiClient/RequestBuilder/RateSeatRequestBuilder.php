<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 9:33 AM
 */

namespace Application\Lib\RateSeat\RestApiClient\RequestBuilder;


use Application\Definition\UintTypeNotEmpty;
use Application\Lib\RateSeat\RestApiClient\RateSeatRestApiClientConfigVo;

class RateSeatRequestBuilder
{


    /**
     * @param RateSeatRestApiClientConfigVo $clientConfigVo
     */
    public function __construct( RateSeatRestApiClientConfigVo $clientConfigVo )
    {
        $this->clientConfigVo = $clientConfigVo;
    }


    /**
     * @var RateSeatRestApiClientConfigVo
     */
    private $clientConfigVo;


    /**
     * @return RateSeatRestApiClientConfigVo
     */
    private function getClientConfigVo()
    {
        return $this->clientConfigVo;
    }

    /**
     * @param $httpMethod
     * @param $resourceUriPath
     * @param $curlData
     *
     * @return RateSeatResourceRequest
     */
    public function createRequest( $httpMethod, $resourceUriPath, $curlData )
    {
        return new RateSeatResourceRequest(
            $httpMethod, $resourceUriPath, $curlData
        );
    }

    /**
     * @param RateSeatResourceRequest $resourceRequest
     * @param UintTypeNotEmpty        $nonceTimestamp
     *
     * @return RateSeatResourceRequestSigned
     */
    public function createRequestSigned(
        RateSeatResourceRequest $resourceRequest,
        UintTypeNotEmpty $nonceTimestamp
    )
    {
        return new RateSeatResourceRequestSigned(
            $this->getClientConfigVo(),
            $resourceRequest,
            $nonceTimestamp
        );
    }


    public function makeRequestCurl(
        $httpMethod,
        $requestUri,
        $requestData,
        UintTypeNotEmpty $nonceTimestamp
    )
    {

        $request = $this->createRequest(
            $httpMethod,
            $requestUri,
            $requestData
        );

        $requestSigned = $this->createRequestSigned(
            $request,
            $nonceTimestamp
        );

        $requestSigned->signRequest();


        $curlData = array(
            'returnTransfer' => true,
            'url'            => (string)$requestSigned->getRequestUrlInfo(),
            'headers'        => $requestSigned->getRequestHeaders(),
            'customRequest'  => $requestSigned->getRequestHttpMethod(),
            'postFields'     => $requestSigned->getRequestPostFieldsText(),
        );


        ksort( $curlData );
        echo PHP_EOL . PHP_EOL . json_encode( $curlData ) . PHP_EOL . PHP_EOL;


        $ch = curl_init( $curlData[ 'url' ] );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, $curlData[ 'customRequest' ] );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $curlData[ 'postFields' ] );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, $curlData[ 'returnTransfer' ] );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $curlData[ 'headers' ] );


        $startTs    = microtime( true );
        $resultText = curl_exec( $ch );
        $stopTs     = microtime( true );

        $resultData = json_decode( $resultText, true );


        var_dump(
            array(

                'response' => $resultData,
                'duration' => $stopTs - $startTs,
            )
        );

    }


} 