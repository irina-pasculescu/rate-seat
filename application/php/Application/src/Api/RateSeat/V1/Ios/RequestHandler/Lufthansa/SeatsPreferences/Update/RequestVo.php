<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\Seatspreferences\Load;


use Application\Api\Base\Server\BaseRequestException as RequestException;
use Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Base\Request\BaseGetFlightStatusRequestVo;
use Application\Utils\ClassUtil;


class RequestVo extends BaseGetFlightStatusRequestVo
{
    /**
     * @return $this
     * @throws RequestException
     */
    public function validate()
    {
        // TODO: Implement validate() method.
    }

} 