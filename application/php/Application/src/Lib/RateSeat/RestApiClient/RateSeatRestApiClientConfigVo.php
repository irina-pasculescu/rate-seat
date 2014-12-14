<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/10/14
 * Time: 4:28 PM
 */

namespace Application\Lib\RateSeat\RestApiClient;


use Application\BaseVo;
use Application\Definition\StringStrictNotEmptyType;
use Application\Lib\Url\PhutilURI;
use Application\Utils\ClassUtil;

class RateSeatRestApiClientConfigVo extends BaseVo
{


    const KEY_API_BASE_URI = 'apiBaseUri';
    const KEY_API__TOKEN   = 'apiToken';

    /**
     * @return string
     */
    public function getApiBaseUri()
    {
        $key   = $this::KEY_API_BASE_URI;
        $value = $this->getDataKey( $key );

        return (string)StringStrictNotEmptyType::cast( $value, '' );
    }

    /**
     * @return PhutilURI
     */
    public function getApiBaseUriParsed()
    {
        $value = new PhutilURI(
            $this->getApiBaseUri()
        );

        return $value;
    }

    /**
     * @return string
     */
    public function getApiHost()
    {
        return (string)$this->getApiBaseUriParsed()->getDomain();
    }


    /**
     * @return string
     */
    public function getApiToken()
    {
        $key   = $this::KEY_API__TOKEN;
        $value = $this->getDataKey( $key );

        return (string)StringStrictNotEmptyType::cast( $value, '' );
    }


    /**
     * @return $this
     * @throws \Exception
     */
    public function validate()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_API_BASE_URI;
        $value = $this->getApiBaseUri();
        if ( empty( $value ) ) {

            throw new \Exception(
                'Invalid clientConfig.' . $key . '!'
                . ' (' . $method . ')'
            );
        }

        $key   = $this::KEY_API__TOKEN;
        $value = $this->getApiToken();
        if ( empty( $value ) ) {

            throw new \Exception(
                'Invalid clientConfig.' . $key . '!'
                . ' (' . $method . ')'
            );
        }

        return $this;
    }


}