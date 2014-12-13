<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 4/24/14
 * Time: 9:40 AM
 */
namespace Application\Api\RateSeat\V1\Admin\Server;

use
    Application\Api\Base\Server\ApiManagerSettingsVo as BaseApiManagerSettingsVo;
use Application\Mvo\ApplicationSettings\ApplicationSettingsMvo;

/**
 * Class ApiManagerSettingsVo
 *
 * @package Application\Api\RateSeat\V1\Admin\Server
 */
class ApiManagerSettingsVo extends BaseApiManagerSettingsVo
{

    const FEATURE_NAME
        = ApplicationSettingsMvo::DATA_KEY_CASINO_API_EXAMPLE_V1_API_MANAGER;

    /**
     * @return $this
     */
    public function validate()
    {
        return $this;
    }


}