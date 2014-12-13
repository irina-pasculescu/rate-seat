<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 12/12/14
 * Time: 10:41 AM
 */

namespace Application\Api\RateSeat\V1\Base;

use Application\Api\Base\Server\BaseRequestHandler;
use Application\Api\RateSeat\V1\Shared\RateSeatApiClientFacade;
use Application\Api\RateSeat\V1\Shared\RateSeatApiSettingsManager;

abstract class BaseRateSeatApiRequestHandler extends BaseRequestHandler
{


    // ======= rate-seat api client builder ==========
    //  you may want to override this in mock or console implementations

    /**
     * @var RateSeatApiClientFacade
     */
    protected $rateSeatApiClientFacade;

    /**
     * @return RateSeatApiClientFacade
     */
    protected function getRateSeatApiClientFacade()
    {
        if (!$this->rateSeatApiClientFacade) {
            $settingsManager = RateSeatApiSettingsManager::getInstance();

            $this->rateSeatApiClientFacade = new RateSeatApiClientFacade(
                $settingsManager->getApiClientSettingsVo()
            );
        }

        return $this->rateSeatApiClientFacade;
    }

} 