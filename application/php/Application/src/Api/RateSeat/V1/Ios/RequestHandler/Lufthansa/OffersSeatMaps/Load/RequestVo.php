<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\OffersSeatMaps\Load;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use \Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Base\Request\BaseGetFlightStatusRequestVo;
use Application\Utils\ClassUtil;


class RequestVo extends BaseGetFlightStatusRequestVo
{

    /*

    'FlightStatus::get' => array(
             'method' => 'GET',
             'URI' => '/v1/operations/flightstatus/LH400/2014-12-15?api_key=fk9qgddrt9uf4k7ug6w97xym',
             'data' => array(
                 'flightNumber' => LH400,
                 'date' => '2014-12-15',
                 'origin' => 'FRA',
                 'destination' => 'JFK',
                 'cabinClass' => 'Y',
             ),
         ),

    Response: obj with flights details

     */


    // ======== implement abstracts =========

    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        $this->validateFlightNumber();
        $this->validateDate();
        $this->validateOrigin();
        $this->validateDestination();
        $this->validateCabinClass();

        return $this;
    }

    // ======== overrides ========

    /**
     * @return string
     */
    public function getFlightNUmber()
    {
        // make it public
        return parent::getFlightNumber();
    }


    /**
     * @return string
     */
    public function getDate()
    {
        // make it public
        return parent::getDate();
    }

    // ======== custom additions ========

    /**
     * @return string
     */
    public function getOrigin()
    {
        return $this->getDataKey( 'origin' );
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->getDataKey( 'destination' );
    }

    /**
     * @return string
     */
    public function getCabinClass()
    {
        return $this->getDataKey( 'cabinClass' );
    }


    /**
     * @return $this
     * @throws RequestException
     */
    protected function validateOrigin()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_ORIGIN;
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


    /**
     * @return $this
     * @throws RequestException
     */
    protected function validateDestination()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_DESTINATION;
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


    /**
     * @return $this
     * @throws RequestException
     */
    protected function validateCabinClass()
    {
        $method = ClassUtil::getQualifiedMethodName( $this, __METHOD__, true );

        $key   = $this::KEY_CABIN_CLASS;
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