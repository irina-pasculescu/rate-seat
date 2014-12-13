<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 12:05 PM
 */
namespace Application\Api\Example\V1\RequestHandler\Test\GetDate;

use Application\Api\Base\Server\BaseRequestHandler;
use Application\Utils\DateUtil;

/**
 * Class TestGetDateRequestHandler
 *
 * @package Application\Api\Example\V1\RequestHandler\Test\GetDate
 */
class TestGetDateRequestHandler extends BaseRequestHandler
{


    // ============= implement abstracts ==============

    /**
     * @return RequestVo
     */
    protected function getRequestVo()
    {
        if (!$this->requestVo) {
            $this->requestVo = new RequestVo();
        }

        return $this->requestVo;
    }

    /**
     * @return ResponseVo
     */
    protected function getResponseVo()
    {
        if (!$this->responseVo) {
            $this->responseVo = new ResponseVo();
        }

        return $this->responseVo;
    }


    /**
     * @throws \Exception
     * @return $this
     */
    protected function execute()
    {
        $responseVo = $this->getResponseVo();
        $requestVo = $this->getRequestVo();

        $requestMicroTime = $this->getRequestMicroTimestamp();
        $responseVo->setRequestMicroTimestamp($requestMicroTime);
        $requestTimestamp = $this->getRequestTimestamp()->getValue();
        $responseVo->setRequestTimestamp($requestTimestamp);

        $responseVo->setDateTimezoneLocal(
            DateUtil::getDateTimeZoneNameDefault()
        );
        $requestDate = DateUtil::createDateTime(
            $requestTimestamp,
            $requestTimestamp
        );
        $responseVo->setRequestDate($requestDate->format(DATE_ISO8601));

        $requestDate = $requestVo->getDate();
        if ($requestDate !== null) {

            $dateTime = DateUtil::createDateTime(
                $requestDate,
                $requestTimestamp
            );
            $responseVo->setDateTimestamp($dateTime->getTimestamp());
            $responseVo->setDate($dateTime->format(DATE_ISO8601));

            $dateTimeUtc = DateUtil::toUtcDateTime($dateTime);
            $responseVo->setDateUtc($dateTimeUtc->format(DATE_ISO8601));

            $dateTimeLocal = DateUtil::toLocalDateTime($dateTimeUtc);
            $responseVo->setDateLocal($dateTimeLocal->format(DATE_ISO8601));
        }


        return $this;
    }


} 