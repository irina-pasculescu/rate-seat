<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 11:17 AM
 */

namespace Application\Lib\RateSeat\RestApiClient\Api\Base\Request;

/**
 * Class BaseRateSeatApiClientRequest
 * @package Application\Lib\RateSeat\RestApiClient\Api\Base\Request
 */
abstract class BaseRateSeatApiClientRequest
{


    const HTTP_METHOD = 'GET';

    const RESOURCE_URI_TEMPLATE = '';


    /**
     *
     */
    public function __construct()
    {
        $this->parse();
    }


    /**
     * @return $this
     */
    abstract protected function parse();


    /**
     * @return string
     */
    public function getHttpMethod()
    {
        return $this::HTTP_METHOD;
    }

    /**
     * @var string
     */
    protected $resourceUri = '';

    /**
     * @return string
     */
    public function getResourceUri()
    {
        return (string)$this->resourceUri;
    }


    /**
     * @var BaseRateSeatApiClientRequestVo
     */
    protected $vo;


    /**
     * @return BaseRateSeatApiClientRequestVo
     */
    protected function getVo()
    {
        if ( !$this->vo ) {
            $this->vo = $this->createVo();
        }

        return $this->vo;
    }

    /**
     * @return array|null
     */
    public function getData()
    {
        return $this->getVo()->getData();
    }


    private $curlData;

    public function getCurlData()
    {
        return $this->curlData;
    }

    public function setCurlData()
    {
        return $this->curlData;
    }


}