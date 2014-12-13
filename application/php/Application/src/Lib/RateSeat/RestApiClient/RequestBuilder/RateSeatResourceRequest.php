<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 9:44 AM
 */

namespace Application\Lib\RateSeat\RestApiClient\RequestBuilder;


class RateSeatResourceRequest {


    /**
     * @param $httpMethod
     * @param $resourceUriPath
     * @param $curlData
     */
    public function __construct($httpMethod, $resourceUriPath, $curlData)
    {
        $this->httpMethod = $httpMethod;
        $this->resourceUriPath = $resourceUriPath;
        $this->curlData = $curlData;


    }

    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return (string)$this->httpMethod;
    }

    /**
     * @return array|null
     */
    public function getCurlData()
    {
        $value = $this->curlData;
        if(!is_array($value)) {

            return null;
        }

        return (array)$value;
    }

    /**
     * @return string
     */
    public function getResourceUriPath()
    {
        return $this->resourceUriPath;
    }





} 