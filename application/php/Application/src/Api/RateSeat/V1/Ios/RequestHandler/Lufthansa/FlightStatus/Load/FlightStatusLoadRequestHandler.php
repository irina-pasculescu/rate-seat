<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Load;

use Application\Api\Base\Server\BaseRequestHandler;
use Application\Lib\RateSeat\RestApiClient\Api\FlightStatus\Load\RateSeatApiClientRequest;

/**
 * Class FlightStatusLoadRequestHandler
 * @package Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\FlightStatus\Load
 */
class FlightStatusLoadRequestHandler extends BaseRequestHandler
{


    // ============= implement abstracts ==============

    /**
     * @return RequestVo
     */
    protected function getRequestVo()
    {
        if ( !$this->requestVo ) {
            $this->requestVo = new RequestVo();
        }

        return $this->requestVo;
    }

    /**
     * @return ResponseVo
     */
    protected function getResponseVo()
    {
        if ( !$this->responseVo ) {
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
        // make request to Lufthansa
        // create rateSeat api request
        $settings           = $this->getRateSeatMvoSettings();

        $requestVo    = $this->getRequestVo();
        $flightNumber = $requestVo->getFlightNUmber();
        $date         = $requestVo->getDate();


        $rateSeatApiRequest = new RateSeatApiClientRequest(
            $settings->getApiToken(),
            $flightNumber,
            $date,
            array()
        );

        // execute rateSeat api request
        $rateSeatApiClientFacade = $this->getRateSeatApiClientFacade();

        $clientStatus = $rateSeatApiClientFacade->makeRequest(
            $rateSeatApiClientFacade->getRestApiClientConfigVo(),
            $rateSeatApiClientFacade->getHttpClientOptionsVo(),
            $rateSeatApiRequest,
            $this->getRequestTimestamp()
        );

        // handle rateSeat api response
        if ( $clientStatus->hasException() ) {
            var_dump( $clientStatus->getException() );exit;
        }

        $rateSeatResponse = array(
            'body'     => $clientStatus->getResponseBodyData(),
            'status'   => $clientStatus->getResponseHttpStatusCode(),
            'duration' => $clientStatus->getDuration(),
        );

        $responseVo = $this->getResponseVo();
        $responseVo->setData( $rateSeatResponse );


        return $this;
    }


    private $settingsVo;

    private function getRateSeatMvoSettings()
    {
        if ( !$this->settingsVo ) {
            $appSettings      = $this->getModel()->getApplicationSettingsMvo();
            $this->settingsVo = $appSettings->getRateSeatApiClientSettingsVo();
        }

        return $this->settingsVo;

    }
} 