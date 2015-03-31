<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/8/14
 * Time: 4:26 PM
 */

namespace Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\SeatsPreferences\Update;

use Application\Api\Base\Server\BaseRequestHandler;
use Application\Lib\RateSeat\RestApiClient\Api\SeatsPreferences\Load\RateSeatApiClientRequest;

/**
 * Class SetSeatsPreferencesRequestHandler
 * @package Application\Api\RateSeat\V1\Ios\RequestHandler\Lufthansa\SeatsPreferences\Update
 */
class SetSeatsPreferencesRequestHandler extends BaseRequestHandler
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
        // get preferences from cb
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