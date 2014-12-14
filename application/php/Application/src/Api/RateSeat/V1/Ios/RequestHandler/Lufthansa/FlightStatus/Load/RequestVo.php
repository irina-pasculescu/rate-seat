<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Load;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Base\Request\BaseGetFlightStatusRequestVo;


class RequestVo extends BaseGetFlightStatusRequestVo
{


    /*

    'FlightStatus::get' => array(
             'method' => 'GET',
             'URI' => '/v1/operations/flightstatus/LH400/2014-12-15?api_key=fk9qgddrt9uf4k7ug6w97xym',
             'data' => array(
                 'flightNumber' => LH400,
                 'date' => '2014-12-15',
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
} 