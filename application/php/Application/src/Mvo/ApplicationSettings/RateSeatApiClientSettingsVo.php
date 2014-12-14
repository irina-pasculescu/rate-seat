<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/11/14
 * Time: 3:14 PM
 */

namespace Application\Mvo\ApplicationSettings;


use Application\BaseVo;
use Application\Definition\BoolType;
use Application\Definition\StringStrictNotEmptyType;
use Application\Definition\UfloatTypeNotEmpty;
use Application\Utils\ClassUtil;

/**
 * Class RateSeatApiClientSettingsVo
 * @package Application\Mvo\ApplicationSettings
 */
class RateSeatApiClientSettingsVo extends BaseVo
{

    const KEY_ENABLED             = 'enabled';
    const KEY_API_BASE_URI        = 'apiBaseUri';
    const KEY_API_TOKEN           = 'apiToken';
    const KEY_API_CONNECT_TIMEOUT = 'apiConnectTimeOut';
    const KEY_API_REQUEST_TIMEOUT = 'apiRequestTimeOut';

    /*

    "RateSeatApiClient": {
        "enabled": true,
        "apiBaseUri": "https://api.lufthansa.com/
    // v1/offers/seatmaps/LH2037/TXL/MUC/2014-12-15/C?api_key=fk9qgddrt9uf4k7ug6w97xym,
        "apiToken": "yyyyy",
        "apiConnectTimeOut": 5.1,
        "apiRequestTimeOut": 3.1
    }

    */

    /**
     * @return bool
     */
    public function getEnabled()
    {
        $key   = $this::KEY_ENABLED;
        $value = $this->getDataKey( $key );

        return BoolType::cast( $value, null ) === true;
    }

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
     * @return string
     */
    public function getApiToken()
    {
        $key   = $this::KEY_API_TOKEN;
        $value = $this->getDataKey( $key );

        return (string)StringStrictNotEmptyType::cast( $value, '' );
    }


    /**
     * @return float
     */
    public function getApiConnectTimeout()
    {
        $key   = $this::KEY_API_CONNECT_TIMEOUT;
        $value = $this->getDataKey( $key );

        return (float)UfloatTypeNotEmpty::cast( $value, 0 );
    }

    /**
     * @return float
     */
    public function getApiRequestTimeout()
    {
        $key   = $this::KEY_API_REQUEST_TIMEOUT;
        $value = $this->getDataKey( $key );

        return (float)UfloatTypeNotEmpty::cast( $value, 0 );
    }

    /**
     * @return $this
     * @throws \Exception
     */
    public function validate()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key      = $this::KEY_ENABLED;
        $rawValue = $this->getDataKey( $key );
        if ( !BoolType::isValid( $rawValue ) ) {

            throw new \Exception(
                'Invalid settings.' . $key . ' !'
                . ' Must be bool type!'
                . ' (' . $method . ')'
            );
        }

        $key   = $this::KEY_API_BASE_URI;
        $value = $this->getApiBaseUri();
        if ( empty( $value ) ) {
            // @TODO: add stronger validation

            throw new \Exception(
                'Invalid settings.' . $key . ' !'
                . ' Must be string type - not empty!'
                . ' (' . $method . ')'
            );
        }

        $key   = $this::KEY_API_TOKEN;
        $value = $this->getApiToken();
        if ( empty( $value ) ) {

            throw new \Exception(
                'Invalid settings.' . $key . ' !'
                . ' Must be string type - not empty!'
                . ' (' . $method . ')'
            );
        }

        $key   = $this::KEY_API_CONNECT_TIMEOUT;
        $value = $this->getApiConnectTimeout();
        if ( empty( $value ) ) {

            throw new \Exception(
                'Invalid settings.' . $key . ' !'
                . ' Must be float type - not empty!'
                . ' (' . $method . ')'
            );
        }

        $key   = $this::KEY_API_REQUEST_TIMEOUT;
        $value = $this->getApiRequestTimeout();
        if ( empty( $value ) ) {

            throw new \Exception(
                'Invalid settings.' . $key . ' !'
                . ' Must be float type - not empty!'
                . ' (' . $method . ')'
            );
        }

        return $this;
    }


} 