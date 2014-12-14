<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:40 AM
 */
namespace Application\Api\RateSeat\V1\Ios\Server;

use Application\Api\Base\Server\ApiManagerSettingsVo as BaseApiManagerSettingsVo;
use Application\Mvo\ApplicationSettings\ApplicationSettingsMvo;

/**
 * Class ApiManagerSettingsVo
 * @package Application\Api\RateSeat\V1\Ios\Server
 */
class ApiManagerSettingsVo extends BaseApiManagerSettingsVo
{

    const FEATURE_NAME
        = ApplicationSettingsMvo::KEY_RATE_SEAT_API_CLIENT;

    /**
     * @return $this
     */
    public function validate()
    {
        return $this;
    }


}