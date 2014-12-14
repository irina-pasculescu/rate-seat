<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 9:55 AM
 */

namespace Application\Lib\RateSeat\RestApiClient;


use Application\BaseVo;
use Application\Definition\UfloatTypeNotEmpty;

/**
 * Class HttpClientOptionsVo
 * @package Application\Lib\RateSeatApi\RestApiClient
 */
class HttpClientOptionsVo extends BaseVo
{

    const KEY_CONNECT_TIMEOUT = 'connect_timeout';
    const KEY_REQUEST_TIMEOUT = 'timeout';


    /**
     * @return float
     */
    public function getConnectTimeout()
    {
        $key   = $this::KEY_CONNECT_TIMEOUT;
        $value = $this->getDataKey( $key );

        return (float)UfloatTypeNotEmpty::cast( $value, 0 );
    }

    /**
     * @param UfloatTypeNotEmpty $value
     *
     * @return $this
     */
    public function setConnectTimeout( UfloatTypeNotEmpty $value )
    {
        $key = $this::KEY_CONNECT_TIMEOUT;

        $this->setDataKey( $key, $value->getValue() );

        return $this;
    }


    /**
     * @return float
     */
    public function getRequestTimeout()
    {
        $key   = $this::KEY_REQUEST_TIMEOUT;
        $value = $this->getDataKey( $key );

        return (float)UfloatTypeNotEmpty::cast( $value, 0 );
    }

    /**
     * @param UfloatTypeNotEmpty $value
     *
     * @return $this
     */
    public function setRequestTimeout( UfloatTypeNotEmpty $value )
    {
        $key = $this::KEY_REQUEST_TIMEOUT;

        $this->setDataKey( $key, $value->getValue() );

        return $this;
    }


}