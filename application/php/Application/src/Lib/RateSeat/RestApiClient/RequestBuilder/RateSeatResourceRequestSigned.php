<?php
/**
 * Created by IntelliJ IDEA.
 * User: irina
 * Date: 12/13/14
 * Time: 9:23 PM
 */

namespace Application\Lib\RateSeat\RestApiClient\RequestBuilder;

use Application\Definition\UintTypeNotEmpty;
use Application\Lib\RateSeat\RestApiClient\RateSeatRestApiClientConfigVo;
use Application\Lib\Url\PhutilURI;

class RateSeatResourceRequestSigned
{


    /**
     * @param RateSeatRestApiClientConfigVo $clientConfigVo
     * @param RateSeatResourceRequest       $resourceRequest
     * @param UintTypeNotEmpty              $nonceTimestamp
     */
    public function __construct(
        RateSeatRestApiClientConfigVo $clientConfigVo,
        RateSeatResourceRequest $resourceRequest,
        UintTypeNotEmpty $nonceTimestamp
    )
    {
        $this->clientConfigVo  = $clientConfigVo;
        $this->resourceRequest = $resourceRequest;
        $this->nonceTimestamp  = $nonceTimestamp;
    }

    /**
     * @var UintTypeNotEmpty
     */
    private $nonceTimestamp;

    /**
     * @return UintTypeNotEmpty
     */
    private function getNonceTimestamp()
    {
        return $this->nonceTimestamp;
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
     * @var RateSeatResourceRequest
     */
    private $resourceRequest;

    /**
     * @return RateSeatResourceRequest
     */
    public function getResourceRequest()
    {
        return $this->resourceRequest;
    }


    /**
     * @var string
     */
    private $requestPostFieldsText = '';

    /**
     * @return string
     */
    public function getRequestPostFieldsText()
    {
        return (string)$this->requestPostFieldsText;
    }

    /**
     * @var array
     */
    private $requestHeaders = array();

    /**
     * @return array
     */
    public function getRequestHeaders()
    {
        return (array)$this->requestHeaders;
    }



    // ===================================

    /**
     * @return $this
     */
    private function resetAll()
    {
        $this->requestPostFieldsText = '';
        $this->requestHeadersSigned  = array();
        $this->requestHeaders        = array();

        return $this;
    }

    /**
     * @return $this
     */
    public function signRequest()
    {
        $this->resetAll();

        $this->createRequestNonceRateSeatDate();

        $this->createCanonicalRequest();

        $this->createRequestHeaderContentLength();
        $this->createRequestHeaderAccept();

        // build request headers
        $requestHeadersAll = array();

        // headers signed
        $headers = $this->getRequestHeadersSigned();
        foreach ( $headers as $header ) {
            $requestHeadersAll[ ] = $header;
        }

        // header: content length
        $requestHeadersAll[ ] = $this->getRequestHeaderContentLength();
        // header: accept
        $requestHeadersAll[ ] = $this->getRequestHeaderAccept();

        $this->requestHeaders = $requestHeadersAll;


        return $this;
    }

    private $requestHttpMethod = '';

    /**
     * @return string
     */
    public function getRequestHttpMethod()
    {
        return (string)$this->requestHttpMethod;
    }


    /**
     * @var string
     */
    private $requestCanonicalUriPath = '';

    /**
     * @return string
     */
    public function getRequestCanonicalUriPath()
    {
        return $this->requestCanonicalUriPath;
    }

    /**
     * @var PhutilURI
     */
    private $requestUrlInfo;

    /**
     * @return PhutilURI
     */
    public function getRequestUrlInfo()
    {
        return $this->requestUrlInfo;
    }


    /**
     * @var string
     */
    private $requestNonceRateSeatDate = '';

    /**
     * @return $this
     */
    private function createRequestNonceRateSeatDate()
    {
        $this->requestNonceRateSeatDate = gmdate(
            'Ymd\THis\Z',
            $this->getNonceTimestamp()->getValue()
        );

        return $this;
    }

    /**
     * @return string
     */
    private function getRequestNonceRateSeatDate()
    {
        return (string)$this->requestNonceRateSeatDate;
    }


    /**
     * @var array
     */
    private $requestHeadersSigned = array();

    /**
     * @return array
     */
    private function getRequestHeadersSigned()
    {
        return $this->requestHeadersSigned;
    }


    /**
     * @return $this
     */
    private function createCanonicalRequest()
    {

        $configVo = $this->getClientConfigVo();
        $apiHost  = $configVo->getApiHost();

        $request                 = $this->getResourceRequest();
        $httpMethod              = $request->getHttpMethod();
        $this->requestHttpMethod = $httpMethod;

        $canonicalUri = $request->getResourceUriPath();

        $apiBaseUrl           = (string)$configVo->getApiBaseUriParsed();
        $requestUrlInfo       = new PhutilURI(
            $apiBaseUrl
        );
        $this->requestUrlInfo = $requestUrlInfo;
        $requestUrlInfo->setPath( $canonicalUri );

        $this->requestCanonicalUriPath = $canonicalUri;


        $curlData     = $request->getCurlData();
        $curlDataText = '';
        if ( is_array( $curlData ) ) {
            $curlDataText = json_encode( $curlData );
        }
        $this->requestPostFieldsText = $curlDataText;


        $requestHeadersSigned       = array();
        $this->requestHeadersSigned = $requestHeadersSigned;


        return $this;
    }

    /**
     * @var string
     */
    private $requestHeaderContentLength = '';

    /**
     * @return string
     */
    private function getRequestHeaderContentLength()
    {
        return (string)$this->requestHeaderContentLength;
    }

    /**
     * @return $this
     */
    private function createRequestHeaderContentLength()
    {
        $curlDataText                     = $this->getRequestPostFieldsText();
        $this->requestHeaderContentLength = 'Content-Length: ' . strlen( $curlDataText );

        return $this;
    }

    /**
     * @var string
     */
    private $requestHeaderAccept = '';

    /**
     * @return string
     */
    private function getRequestHeaderAccept()
    {
        return (string)$this->requestHeaderAccept;
    }

    /**
     * @return $this
     */
    private function createRequestHeaderAccept()
    {
        $this->requestHeaderAccept = 'Accept: application/json';

        return $this;
    }

} 