<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/9/14
 * Time: 12:01 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Base\Request;

use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\Base\Server\BaseRequestVo;
use Application\Definition\StringStrictNotEmptyType;
use Application\Utils\ClassUtil;

abstract class BaseGetFlightStatusRequestVo extends BaseRequestVo
{

    const KEY_FLIGHT_NUMBER = 'flightNumber';
    const KEY_DATE          = 'date';
    const KEY_ORIGIN        = 'origin';
    const KEY_DESTINATION   = 'destination';
    const KEY_CABIN_CLASS   = 'cabinClass';



    // ========== getters ================

    /**
     * @return string
     */
    protected function getFlightNumber()
    {
        $key   = $this::KEY_FLIGHT_NUMBER;
        $value = $this->getDataKey( $key );

        return (string)StringStrictNotEmptyType::cast( $value, '' );
    }


    /**
     * @return string
     */
    protected function getDate()
    {
        $key   = $this::KEY_DATE;
        $value = $this->getDataKey( $key );

        return StringStrictNotEmptyType::cast( $value, -1 );
    }


    // ============= validators ==============

    /**
     * @return $this
     * @throws RequestException
     */
    protected function validateFlightNumber()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_FLIGHT_NUMBER;
        $value = $this->getFlightNumber();
        if ( empty( $value ) ) {

            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' (' . $method . ')'
            );
        }

        return $this;
    }

    /**
     * @return $this
     * @throws RequestException
     */
    protected function validateDate()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_DATE;
        $value = $this->getDate();
        if ( empty( $value ) ) {


            throw new RequestException(
                'Invalid request.' . $key . ' !'
                . ' Must be string - not empty !'
                . ' (' . $method . ')'
            );


        }

        return $this;
    }


}